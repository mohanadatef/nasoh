<?php

namespace Modules\Acl\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Modules\Acl\Http\Requests\Permission\Dashboard\CreateRequest;
use Modules\Acl\Http\Requests\Permission\Dashboard\EditRequest;
use Modules\Acl\Http\Resources\Permission\Dashboard\PermissionListResource;
use Modules\Acl\Http\Resources\Permission\Dashboard\PermissionResource;
use Modules\Acl\Service\PermissionService;
use Modules\Basic\Http\Controllers\BasicController;

class PermissionController extends BasicController
{
    public $service;

    public function __construct(PermissionService $Service)
    {
        $this->service = $Service;
        $this->middleware('auth:dashboard');
        $this->middleware('permission:permission-show')->only(['index','show']);
        $this->middleware('permission:permission-create')->only('store');
        $this->middleware('permission:permission-edit')->only('update');
        $this->middleware('permission:permission-delete')->only('delete');
    }

    public function show($id)
    {
        $data = $this->service->show($id);
        if ($data) {
            return $this->apiResponse(new PermissionResource($data), 'Done');
        }
        return $this->unKnowError();
    }

    public function store(CreateRequest $request)
    {
        $data = $this->service->store($request);
        if ($data) {
            return $this->createResponse(new PermissionResource($data), 'create done');
        }
        return $this->unKnowError();
    }

    public function update(EditRequest $request, $id)
    {
        $data = $this->service->update($request,$id);
        if ($data) {
            return $this->updateResponse(new PermissionResource($data), 'update Done');
        }
        return $this->unKnowError();
    }

    public function index(Request $request)
    {
        return PermissionListResource::collection($this->apiResponse($this->service->list($request, $this->pagination(), $this->perPage()), 'Done'));
    }
}
