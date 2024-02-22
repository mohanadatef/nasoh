<?php

namespace Modules\Acl\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Modules\Acl\Http\Requests\Adviser\Dashboard\UpdateRequest;
use Modules\Acl\Http\Resources\Adviser\Dashboard\AdviserResource;
use Modules\Acl\Http\Resources\Adviser\Dashboard\AdviserListResource;
use Modules\Acl\Http\Resources\Adviser\Dashboard\Report\AdviserProfileReportResource;
use Modules\Acl\Http\Resources\Adviser\Dashboard\Report\AdviserReportResource;
use Modules\Acl\Service\AdviserService;
use Modules\Basic\Http\Controllers\BasicController;

class AdviserController extends BasicController
{
    protected $service;

    public function __construct(AdviserService $Service)
    {
        $this->middleware('auth:dashboard');
        $this->middleware('permission:adviser-show')->only(['index', 'show', 'report']);
        $this->middleware('permission:adviser-edit')->only('update');
        $this->middleware('permission:adviser-delete')->only('delete');
        $this->middleware('permission:adviser-status')->only('changeStatus');
        $this->service = $Service;
    }

    public function profile($id)
    {
        $data = $this->service->show($id);
        if($data)
        {
            return $this->apiResponse(new AdviserResource($data), 'Done');
        }
        return $this->unKnowError();
    }

    public function update(UpdateRequest $request,$id)
    {
        $data = $this->service->update($request, $id);
        if($data)
        {
            return $this->updateResponse(new AdviserResource($data), 'update Done');
        }
        return $this->unKnowError();
    }

    public function index(Request $request)
    {
        return $this->apiResponse(AdviserListResource::collection($this->service->list($request, $this->pagination(),
            $this->perPage())), 'Done');
    }

    public function report(Request $request)
    {
        $total = $this->service->findBy($request,get:'count');
        $active = $this->service->findBy(new Request(['status'=>1]),get:'count');
        $inactive = $this->service->findBy(new Request(['status'=>0]),get:'count');
        $advice = $this->service->findBy(new Request(['status'=>1]),recursiveRel:['advice'=>['type'=>'whereHas']],get:'count');
        $data = ['total' => $total, 'advice' => $advice, 'active' => $active, 'inactive' => $inactive];
        return $this->apiResponse(new AdviserReportResource($data), 'Done');
    }

    public function profileReport(Request $request,$id)
    {
        $request->merge(['adviser_id'=>$id]);
        $total = $this->service->findBy($request,get:'count');
        $wallet = $this->show($id)->wallet->balance ?? "";
        $data = ['total' => $total,'wallet' => $wallet];
        return $this->apiResponse(new AdviserProfileReportResource($data), 'Done');
    }
}
