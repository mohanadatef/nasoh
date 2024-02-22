<?php

namespace Modules\Acl\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Modules\Acl\Http\Requests\Client\Dashboard\UpdateRequest;
use Modules\Acl\Http\Resources\Client\Dashboard\ClientListResource;
use Modules\Acl\Http\Resources\Client\Dashboard\ClientResource;
use Modules\Acl\Http\Resources\Client\Dashboard\Report\ClientReportResource;
use Modules\Acl\Service\ClientService;
use Modules\Basic\Http\Controllers\BasicController;

class ClientController extends BasicController
{
    protected $service;

    public function __construct(ClientService $Service)
    {
        $this->middleware('auth:dashboard');
        $this->middleware('permission:client-show')->only(['index', 'show', 'report']);
        $this->middleware('permission:client-edit')->only('update');
        $this->middleware('permission:client-delete')->only('delete');
        $this->middleware('permission:client-status')->only('changeStatus');
        $this->service = $Service;
    }

    public function show($id)
    {
        $data = $this->service->show($id);
        if ($data) {
            return $this->apiResponse(new ClientResource($data), 'Done');
        }
        return $this->unKnowError();
    }

    public function update(UpdateRequest $request,$id)
    {
        $data = $this->service->update($request,$id);
        if ($data) {
            return $this->updateResponse(new ClientResource($data), 'update Done');
        }
        return $this->unKnowError();
    }

    public function report(Request $request)
    {
        $total = $this->service->findBy($request,get:'count');
        $active = $this->service->findBy(new Request(['status'=>1]),get:'count');
        $inactive = $this->service->findBy(new Request(['status'=>0]),get:'count');
        $advice = $this->service->findBy(new Request(['status'=>1]),recursiveRel:['advice'=>['type'=>'whereHas']],get:'count');
        $data = ['total' => $total, 'advice' => $advice, 'active' => $active, 'inactive' => $inactive];
        return $this->apiResponse(new ClientReportResource($data), 'Done');
    }

    public function index(Request $request)
    {
        return $this->apiResponse(ClientListResource::collection($this->service->list($request, $this->pagination(), $this->perPage())), 'Done');
    }
}
