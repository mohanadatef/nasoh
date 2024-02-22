<?php

namespace Modules\Acl\Service;

use Illuminate\Http\Request;
use Modules\Accounting\Service\WalletService;
use Modules\Acl\Http\Resources\Client\Dashboard\ClientListResource;
use Modules\Acl\Repositories\ClientRepository;
use Modules\Basic\Service\BasicService;

class ClientService extends BasicService
{
    protected $repo, $adviserService, $walletService;

    /**
     * Create a new Repository instance.
     *
     * @return void
     */
    public function __construct(ClientRepository $repository, AdviserService $adviserService,
        WalletService $walletService)
    {
        $this->repo = $repository;
        $this->adviserService = $adviserService;
        $this->walletService = $walletService;
    }

    public function findBy(Request $request, $pagination = false, $perPage = 10, $get = '', $recursiveRel = [])
    {
        return $this->repo->findBy($request, pagination: $pagination, perPage: $perPage, get: $get,
            recursiveRel: $recursiveRel);
    }

    public function list(Request $request, $pagination = false, $perPage = 10)
    {
        $moreConditionForFirstLevel = [];
        if(isset($request->search) && !empty($request->search))
        {
            $moreConditionForFirstLevel = [
                'whereCustom' => [
                    'orWhere' => [
                        ['full_name' => $request->search], ['mobile' => $request->search], ['id' => $request->search]
                    ]],
            ];
        }
        return ClientListResource::collection($this->repo->findBy($request, pagination: $pagination, perPage: $perPage,moreConditionForFirstLevel:$moreConditionForFirstLevel,
            orderBy: ['column' => $request->sort_name ?? 'id', 'order' => $request->sort_type ?? 'desc']));
    }

    public function adviserList(Request $request, $pagination = false, $perPage = 10, $recursiveRel = [],
        $moreConditionForFirstLevel = [])
    {
        $request->merge(['status' => activeType()['as']]);
        return $this->adviserService->findBy($request, moreConditionForFirstLevel: $moreConditionForFirstLevel,
            pagination: $pagination, perPage: $perPage, orderBy: ['column' => 'id', 'order' => 'desc'],
            recursiveRel: $recursiveRel);
    }

    public function adviserProfile($id)
    {
        return $this->adviserService->show($id);
    }

    public function store(Request $request)
    {
        $data = $this->walletService->store($request);
        $request->merge(['wallet_id' => $data->id]);
        return $this->repo->save($request);
    }
}
