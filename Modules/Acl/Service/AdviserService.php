<?php

namespace Modules\Acl\Service;

use Illuminate\Http\Request;
use Modules\Accounting\Service\WalletService;
use Modules\Acl\Repositories\AdviserRepository;
use Modules\Basic\Service\BasicService;

class AdviserService extends BasicService
{
    protected $repo,$walletService;

    /**
     * Create a new Repository instance.
     *
     * @return void
     */
    public function __construct(AdviserRepository $repository,WalletService $walletService)
    {
        $this->repo = $repository;
        $this->walletService = $walletService;
    }

    public function findBy(Request $request, $pagination = false, $perPage = 10, $get = '',$orderBy=[],$recursiveRel=[],$moreConditionForFirstLevel=[])
    {
        return $this->repo->findBy($request,moreConditionForFirstLevel:$moreConditionForFirstLevel, pagination:$pagination,perPage: $perPage, get: $get,orderBy: $orderBy,recursiveRel:$recursiveRel);
    }
    public function list(Request $request, $pagination = false, $perPage = 10)
    {
        $moreConditionForFirstLevel=[];
        if(isset($request->search) && !empty($request->search))
        {
            $moreConditionForFirstLevel = [
                'whereCustom' => [
                    'orWhere' => [
                        ['full_name' => $request->search], ['mobile' => $request->search],['id' => $request->search]
                    ]],
            ];
        }
        return $this->repo->findBy($request, pagination:  $pagination, perPage: $perPage,orderBy:['column'=>$request->sort_name ?? 'id','order'=>$request->sort_type ??'desc'],moreConditionForFirstLevel:$moreConditionForFirstLevel);
    }
    public function documentDelete($id)
    {
        return $this->repo->documentDelete($id);
    }
    public function socialDelete($id)
    {
        return $this->repo->socialDelete($id);
    }

    public function store(Request $request)
    {
        $data = $this->walletService->store($request);
        $request->merge(['wallet_id'=>$data->id]);
        return $this->repo->save($request);
    }
}
