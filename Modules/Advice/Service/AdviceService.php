<?php

namespace Modules\Advice\Service;

use Illuminate\Http\Request;
use Modules\Accounting\Service\WalletService;
use Modules\Basic\Service\BasicService;
use Modules\Advice\Repositories\AdviceRepository;
use Modules\Setting\Service\NotificationService;

class AdviceService extends BasicService
{
    protected $repo, $walletService, $chatService, $notificationService;

    /**
     * Create a new Repository instance.
     *
     * @return void
     */
    public function __construct(AdviceRepository $repository, WalletService $walletService, ChatService $chatService,
        NotificationService $notificationService)
    {
        $this->repo = $repository;
        $this->walletService = $walletService;
        $this->chatService = $chatService;
        $this->notificationService = $notificationService;
    }

    public function findBy(Request $request, $pagination = false, $perPage = 10, $get = '',$orderBy=[],$recursiveRel=[],$moreConditionForFirstLevel=[])
    {
        return $this->repo->findBy($request,moreConditionForFirstLevel:$moreConditionForFirstLevel, pagination:$pagination,perPage: $perPage, get: $get,orderBy: $orderBy,recursiveRel:$recursiveRel);
    }

    public function store(Request $request)
    {
        $request->merge(['status_id' => 1, 'label_id' => 1, 'tax' => getSetting('tax_client')->value, 'client_id' => user('client')->id]);
        $advice = $this->repo->save($request);
        $this->chatService->store(new Request(['advice_id' => $advice->id, 'client_id' => user('client')->id, 'document' => $request->document ?? [], 'message' => $request->description]));
        return $advice;
    }

    public function pay(Request $request, $id)
    {
        $data = $this->show($id);
        if($data->label_id == 1)
        {
            if($data->client_id == user('client')->id)
            {
                if($request->payment_id == 1)
                {
                    if(user('client')->wallet->balance >= ($data->price + round($data->price * ($data->tax / 100),
                                2)))
                    {
                        $request->merge(['label_id' => 2]);
                        $data = $this->repo->save($request, $id);
                        $this->walletService->payAdvice($data);
                        $this->notificationService->sendNotificationStatus($data->adviser,
                            statusNotificationText()['adviser'][$data->adviser->lang][2], $data->id);
                        $data->notification()
                            ->create(new Request(['type' => 'adviser', 'receiver_id' => $data->adviser_id, 'action' => 'pay']));
                        return $data;
                    }
                    return ['status' => false, 'message' => 'must add money in wallet'];
                }else
                {
                    $request->merge(['label_id' => 2]);
                    $data = $this->repo->save($request, $id);
                    $this->notificationService->sendNotificationStatus($data->adviser,
                        statusNotificationText()['adviser'][$data->adviser->lang][2], $data->id);
                    $data->notification()
                        ->create(['type' => 'adviser', 'receiver_id' => $data->adviser_id, 'action' => 'pay']);
                    return $data;
                }
            }
            return ['status' => false, 'message' => 'wrong client'];
        }
        return ['status' => false, 'message' => 'wrong status'];
    }

    public function list(Request $request, $pagination = false, $perPage = 10, $moreConditionForFirstLevel = [])
    {
        $recursiveRel = [];
        if(isset($request->search) && !empty($request->search))
        {
            $moreConditionForFirstLevel += [
                'whereCustom' => [
                    'orWhere' => [
                        ['name' => $request->search], ['id' => $request->search]
                    ]],
            ];
            $recursiveRel = ['adviser' => [
                'type' => 'orWhereHas',
                'orWhere' => ['full_name' => ['like', '%' . $request->search . '%']],
            ],
                'client' => [
                    'type' => 'orWhereHas',
                    'orWhere' => ['full_name' => ['like', '%' . $request->search . '%']],
                ]
            ];
        }
        return $this->repo->findBy($request, pagination: $pagination, perPage: $perPage, recursiveRel: $recursiveRel,
            orderBy: ['column'=>$request->sort_name ?? 'id','order'=>$request->sort_type ??'desc'], moreConditionForFirstLevel: $moreConditionForFirstLevel);
    }

    public function doneAdviser($id)
    {
        $request = new Request(['label_id' => 3]);
        $data = $this->repo->save($request, $id);
        $this->notificationService->sendNotificationStatus($data->client,
            statusNotificationText()['client'][$data->client->lang][4], $data->id);
        $data->notification()
            ->create(['type' => 'client', 'receiver_id' => $data->client_id, 'action' => 'done_adviser']);
        return $data;
    }

    public function doneClient($id)
    {
        $request = new Request(['status_id' => 2, 'label_id' => 4]);
        $data = $this->repo->save($request, $id);
        $this->notificationService->sendNotificationStatus($data->adviser,
            statusNotificationText()['adviser'][$data->adviser->lang][5], $data->id);
        $data->notification()
            ->create(['type' => 'adviser', 'receiver_id' => $data->adviser_id, 'action' => 'done_client']);
        return $data;
    }

    public function review(Request $request, $id)
    {
        $data = $this->repo->save($request, $id);
        $this->rate($data);
        return $data;
    }

    public function rejectClient(Request $request, $id)
    {
        $request->merge(['status_id' => 4, 'label_id' => 6]);
        $data = $this->repo->save($request, $id);
        $this->notificationService->sendNotificationStatus($data->adviser,
            statusNotificationText()['adviser'][$data->adviser->lang][7], $data->id);
        $data->notification()
            ->create(['type' => 'adviser', 'receiver_id' => $data->adviser_id, 'action' => 'reject_client']);
        return $data;
    }

    public function rejectAdviser(Request $request, $id)
    {
        $request->merge(['status_id' => 3, 'label_id' => 5]);
        $data = $this->repo->save($request, $id);
        $this->notificationService->sendNotificationStatus($data->client,
            statusNotificationText()['client'][$data->client->lang][6], $data->id);
        $data->notification()
            ->create(['type' => 'client', 'receiver_id' => $data->client_id, 'action' => 'reject_adviser']);
        return $data;
    }

    public function rate($data)
    {
        $countAdvice = $data->adviser->advice->where('status_id', 2)->count();
        $speed = $this->repo->sumAdviceRate($data->adviser_id, 'rate_speed') / $countAdvice;
        $quality = $this->repo->sumAdviceRate($data->adviser_id, 'rate_quality') / $countAdvice;
        $flexibility = $this->repo->sumAdviceRate($data->adviser_id, 'rate_flexibility') / $countAdvice;
        $rate = ($speed + $quality + $flexibility) / 15;
        $data->adviser->update(['rate' => number_format((float)$rate, 2, '.', ''),
            'speed' => number_format((float)$speed, 2, '.', ''),
            'quality' => number_format((float)$quality, 2, '.', ''),
            'flexibility' => number_format((float)$flexibility, 2, '.', '')]);
    }
}
