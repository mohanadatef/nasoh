<?php

namespace Modules\CoreData\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Modules\Basic\Http\Controllers\BasicController;
use Modules\CoreData\Http\Requests\Social\Dashboard\CreateRequest;
use Modules\CoreData\Http\Requests\Social\Dashboard\EditRequest;
use Modules\CoreData\Http\Resources\Social\Dashboard\SocialListResource;
use Modules\CoreData\Http\Resources\Social\Dashboard\SocialResource;
use Modules\CoreData\Service\SocialService;

class SocialController extends BasicController
{
    public $service;

    public function __construct(SocialService $Service)
    {
        $this->middleware('auth:dashboard');
        $this->middleware('permission:social-show')->only(['index','show']);
        $this->middleware('permission:social-create')->only('store');
        $this->middleware('permission:social-edit')->only('update');
        $this->middleware('permission:social-delete')->only('delete');
        $this->middleware('permission:social-status')->only('changeStatus');
        $this->service = $Service;
    }

    public function show($id)
    {
        $data = $this->service->show($id);
        if ($data) {
            return $this->apiResponse(new SocialResource($data), 'Done');
        }
        return $this->unKnowError();
    }

    public function store(CreateRequest $request)
    {
        $data = $this->service->store($request);
        if ($data) {
            return $this->createResponse(new SocialResource($data), 'create done');
        }
        return $this->unKnowError();
    }

    public function update(EditRequest $request, $id)
    {
        $data = $this->service->update($request,$id);
        if ($data) {
            return $this->updateResponse(new SocialResource($data), 'update Done');
        }
        return $this->unKnowError();
    }
    public function index(Request $request)
    {
        return $this->apiResponse(SocialListResource::collection($this->service->list($request,pagination: $this->pagination(),perPage: $this->perPage())), 'Done');
    }
}
