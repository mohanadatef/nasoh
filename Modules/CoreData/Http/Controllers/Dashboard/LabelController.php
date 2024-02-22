<?php

namespace Modules\CoreData\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Modules\Basic\Http\Controllers\BasicController;
use Modules\CoreData\Http\Requests\Label\Dashboard\CreateRequest;
use Modules\CoreData\Http\Requests\Label\Dashboard\EditRequest;
use Modules\CoreData\Http\Resources\Label\Dashboard\LabelListResource;
use Modules\CoreData\Http\Resources\Label\Dashboard\LabelResource;
use Modules\CoreData\Service\LabelService;

class LabelController extends BasicController
{
    public $service;

    public function __construct(LabelService $Service)
    {
        $this->middleware('auth:dashboard');
        $this->middleware('permission:label-show')->only(['index','show']);
        $this->middleware('permission:label-create')->only('store');
        $this->middleware('permission:label-edit')->only('update');
        $this->middleware('permission:label-delete')->only('delete');
        $this->middleware('permission:label-status')->only('changeStatus');
        $this->service = $Service;
    }

    public function show($id)
    {
        $data = $this->service->show($id);
        if ($data) {
            return $this->apiResponse(new LabelResource($data), 'Done');
        }
        return $this->unKnowError();
    }

    public function store(CreateRequest $request)
    {
        $data = $this->service->store($request);
        if ($data) {
            return $this->createResponse(new LabelResource($data), 'create done');
        }
        return $this->unKnowError();
    }

    public function update(EditRequest $request, $id)
    {
        $data = $this->service->update($request,$id);
        if ($data) {
            return $this->updateResponse(new LabelResource($data), 'update Done');
        }
        return $this->unKnowError();
    }
    public function index(Request $request)
    {
        return $this->apiResponse(LabelListResource::collection($this->service->list($request,pagination: $this->pagination(),perPage: $this->perPage())), 'Done');
    }
}
