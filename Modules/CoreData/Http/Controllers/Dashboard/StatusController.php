<?php

namespace Modules\CoreData\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Modules\Basic\Http\Controllers\BasicController;
use Modules\CoreData\Http\Requests\Status\Dashboard\CreateRequest;
use Modules\CoreData\Http\Requests\Status\Dashboard\EditRequest;
use Modules\CoreData\Http\Resources\Status\Dashboard\StatusListResource;
use Modules\CoreData\Http\Resources\Status\Dashboard\StatusResource;
use Modules\CoreData\Service\StatusService;

class StatusController extends BasicController
{
    public $service;

    public function __construct(StatusService $Service)
    {
        $this->middleware('auth:dashboard');
        $this->middleware('permission:status-show')->only(['index','show']);
        $this->middleware('permission:status-create')->only('store');
        $this->middleware('permission:status-edit')->only('update');
        $this->middleware('permission:status-delete')->only('delete');
        $this->middleware('permission:status-status')->only('changeStatus');
        $this->service = $Service;
    }

    public function show($id)
    {
        $data = $this->service->show($id);
        if ($data) {
            return $this->apiResponse(new StatusResource($data), 'Done');
        }
        return $this->unKnowError();
    }

    public function store(CreateRequest $request)
    {
        $data = $this->service->store($request);
        if ($data) {
            return $this->createResponse(new StatusResource($data), 'create done');
        }
        return $this->unKnowError();
    }

    public function update(EditRequest $request, $id)
    {
        $data = $this->service->update($request,$id);
        if ($data) {
            return $this->updateResponse(new StatusResource($data), 'update Done');
        }
        return $this->unKnowError();
    }
    public function index(Request $request)
    {
        return $this->apiResponse(StatusListResource::collection($this->service->list($request,pagination: $this->pagination(),perPage: $this->perPage())), 'Done');
    }
}
