<?php

namespace Modules\Acl\Http\Controllers\Adviser;

use Illuminate\Http\Request;
use Modules\Acl\Http\Requests\Adviser\Adviser\CreateRequest;
use Modules\Acl\Http\Requests\Adviser\Adviser\UpdateRequest;
use Modules\Acl\Http\Resources\Adviser\Adviser\AdviserLoginResource;
use Modules\Acl\Http\Resources\Adviser\Adviser\AdviserProfileResource;
use Modules\Acl\Service\AdviserService;
use Modules\Basic\Http\Controllers\BasicController;

class AdviserController extends BasicController
{
    protected $service;

    public function __construct(AdviserService $Service)
    {
        $this->middleware('auth:adviser')->except(['store']);
        $this->service = $Service;
    }

    public function profile($id)
    {
        if(user('adviser')->id == $id)
        {
            $data = $this->service->show($id);
            if ($data) {
                return $this->apiResponse(new AdviserProfileResource($data), 'Done');
            }
        }
        return $this->unKnowError();
    }

    public function show()
    {
        $data = $this->service->show(user('adviser')->id);
        if ($data) {
            return $this->apiResponse(new AdviserProfileResource($data), 'Done');
        }
        return $this->unKnowError();
    }

    public function store(CreateRequest $request)
    {
        $data = $this->service->store($request);
        if ($data) {
            return $this->createResponse(new AdviserLoginResource($data), 'create done');
        }
        return $this->unKnowError();
    }

    public function update(UpdateRequest $request)
    {
       unset($request->mobile);
        $data = $this->service->update($request,user('adviser')->id);
        if ($data) {
            return $this->updateResponse(new AdviserProfileResource($data), 'update Done');
        }
        return $this->unKnowError();
    }

    public function socialDelete($id)
    {
        $data = $this->service->socialDelete($id);
        if ($data) {
            return $this->deleteResponse('delete done');
        }
        return $this->unKnowError();
    }

    public function documentDelete($id)
    {
        $data = $this->service->documentDelete($id);
        if ($data) {
            return $this->deleteResponse('delete done');
        }
        return $this->unKnowError();
    }

    public function changeSetting(Request $request)
    {
      return $this->updateResponse(new AdviserLoginResource( $this->service->changeStatus(user('adviser')->id, $request->key)),'update Done');
    }
}
