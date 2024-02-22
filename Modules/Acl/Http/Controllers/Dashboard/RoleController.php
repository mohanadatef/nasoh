<?php

namespace Modules\Acl\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Modules\Acl\Http\Requests\Role\Dashboard\CreateRequest;
use Modules\Acl\Http\Requests\Role\Dashboard\EditRequest;
use Modules\Acl\Http\Resources\Role\Dashboard\RoleListResource;
use Modules\Acl\Http\Resources\Role\Dashboard\RoleResource;
use Modules\Acl\Service\RoleService;
use Modules\Basic\Http\Controllers\BasicController;

class RoleController extends BasicController
{
    public $service;

    public function __construct(RoleService $Service)
    {
        $this->service = $Service;
        $this->middleware('auth:dashboard');
        $this->middleware('permission:role-show')->only(['index','show']);
        $this->middleware('permission:role-create')->only('store');
        $this->middleware('permission:role-edit')->only('update');
        $this->middleware('permission:role-delete')->only('delete');
        $this->middleware('permission:role-status')->only('changeStatus');
    }

    public function show($id)
    {
        $data = $this->service->show($id);
        if ($data) {
            return $this->apiResponse(new RoleResource($data), 'Done');
        }
        return $this->unKnowError();
    }

    public function store(CreateRequest $request)
    {
        $data = $this->service->store($request);
        if ($data) {
            return $this->createResponse(new RoleResource($data), 'create done');
        }
        return $this->unKnowError();
    }

    public function update(EditRequest $request, $id)
    {
        $data = $this->service->update($request,$id);
        if ($data) {
            return $this->updateResponse(new RoleResource($data), 'update Done');
        }
        return $this->unKnowError();
    }

    public function index(Request $request)
    {
        return RoleListResource::collection($this->apiResponse($this->service->list($request, $this->pagination(), $this->perPage()), 'Done'));
    }

}
