<?php

namespace Modules\Acl\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Modules\Acl\Http\Requests\User\Dashboard\CreateRequest;
use Modules\Acl\Http\Requests\User\Dashboard\UpdateRequest;
use Modules\Acl\Http\Resources\User\Dashboard\UserListResource;
use Modules\Acl\Http\Resources\User\Dashboard\UserLoginResource;
use Modules\Acl\Http\Resources\User\Dashboard\UserResource;
use Modules\Acl\Service\UserService;
use Modules\Basic\Http\Controllers\BasicController;

class UserController extends BasicController
{
    protected $service;

    public function __construct(UserService $Service)
    {
        $this->middleware('auth:dashboard');
        $this->middleware('permission:user-show')->only(['index','show']);
        $this->middleware('permission:user-create')->only('store');
        $this->middleware('permission:user-edit')->only('update');
        $this->middleware('permission:user-delete')->only('delete');
        $this->middleware('permission:user-status')->only('changeStatus');
        $this->service = $Service;
    }

    public function show($id)
    {
        $data = $this->service->show($id);
        if ($data) {
            return $this->apiResponse(new UserResource($data), 'Done');
        }
        return $this->unKnowError();
    }

    public function store(CreateRequest $request)
    {
        $data = $this->service->store($request);
        if ($data) {
            return $this->createResponse(new UserResource($data), 'create done');
        }
        return $this->unKnowError();
    }

    public function update(UpdateRequest $request, $id)
    {
        $data = $this->service->update($request,$id);
        if ($data) {
            return $this->updateResponse(new UserResource($data), 'update Done');
        }
        return $this->unKnowError();
    }

    public function index(Request $request)
    {
        return UserListResource::collection($this->apiResponse($this->service->list($request, $this->pagination(), $this->perPage()), 'Done'));
    }

    public function changeSetting(Request $request)
    {
        return $this->updateResponse( new UserLoginResource($this->service->changeStatus(user('adviser'), $request->key)),'update Done');
    }
}
