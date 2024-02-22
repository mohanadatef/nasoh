<?php

namespace Modules\Advice\Service;

use Illuminate\Http\Request;
use Modules\Advice\Repositories\AdviceRepository;
use Modules\Basic\Service\BasicService;
use Modules\Advice\Repositories\ChatRepository;
use Modules\Setting\Service\NotificationService;

class ChatService extends BasicService
{
    protected $repo, $adviceRepository, $notificationService;

    /**
     * Create a new Repository instance.
     *
     * @return void
     */
    public function __construct(ChatRepository $repository, AdviceRepository $adviceRepository,
        NotificationService $notificationService)
    {
        $this->repo = $repository;
        $this->adviceRepository = $adviceRepository;
        $this->notificationService = $notificationService;
    }

    public function store(Request $request)
    {
        $advice = $this->adviceRepository->find($request->advice_id);
        if($advice)
        {
        if(((isset($request->client_id) && $advice->client_id ?? 0 == $request->client_id) || (isset($request->adviser_id) && $advice->adviser_id == $request->adviser_id)) && in_array($advice->status_id,
                [1, 2, 3, 4]))
        {
            $data = $this->repo->save($request);
            if($request->adviser_id)
            {
                $user = $advice->client;
            }elseif($request->client_id)
            {
                $user = $advice->adviser;
            }
            if($advice->label_id >= 2)
            {
                $this->notificationService->sendNotificationChat($user, $data->message, $advice->id);
            }
            return $data;
        }
        }
        return false;
    }
}
