<?php

namespace Modules\Acl\Http\Controllers\Client;

use Illuminate\Http\Request;
use Modules\Acl\Http\Requests\Client\Client\CreateRequest;
use Modules\Acl\Http\Requests\Client\Client\UpdateRequest;
use Modules\Acl\Http\Resources\Client\Client\ClientLoginResource;
use Modules\Acl\Http\Resources\Client\Client\ClientProfileResource;
use Modules\Acl\Service\ClientService;
use Modules\Basic\Http\Controllers\BasicController;

class ClientController extends BasicController
{
    protected $service;

    public function __construct(ClientService $Service)
    {
        $this->middleware('auth:client')->except(['store']);
        $this->service = $Service;
    }

    public function profile($id)
    {
        if(user('client')->id == $id)
        {
            $data = $this->service->show($id);
            if ($data) {
                return $this->apiResponse(new ClientProfileResource($data), 'Done');
            }
        }
        return $this->unKnowError();
    }

    public function show()
    {
        $data = $this->service->show(user('client')->id);
        if ($data) {
            return $this->apiResponse(new ClientProfileResource($data), 'Done');
        }
        return $this->unKnowError();
    }

    public function store(CreateRequest $request)
    {
        $data = $this->service->store($request);
        if ($data) {
            return $this->createResponse(new ClientLoginResource($data), 'create done');
        }
        return $this->unKnowError();
    }

    public function update(UpdateRequest $request)
    {
        $data = $this->service->update($request,user('client')->id);
        if ($data) {
            return $this->updateResponse(new ClientProfileResource($data), 'update Done');
        }
        return $this->unKnowError();
    }

    public function changeSetting(Request $request)
    {
        return $this->updateResponse( new ClientLoginResource($this->service->changeStatus(user('client')->id, $request->key)),'update Done');
    }
}
