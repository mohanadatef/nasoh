<?php

namespace Modules\CoreData\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Modules\Basic\Http\Controllers\BasicController;
use Modules\CoreData\Http\Requests\Nationality\Dashboard\CreateRequest;
use Modules\CoreData\Http\Requests\Nationality\Dashboard\EditRequest;
use Modules\CoreData\Http\Resources\Nationality\Dashboard\NationalityListResource;
use Modules\CoreData\Http\Resources\Nationality\Dashboard\NationalityResource;
use Modules\CoreData\Service\NationalityService;

class NationalityController extends BasicController
{
    public $service;

    public function __construct(NationalityService $Service)
    {
        $this->middleware('auth:dashboard');
        $this->middleware('permission:nationality-show')->only(['index','show']);
        $this->middleware('permission:nationality-create')->only('store');
        $this->middleware('permission:nationality-edit')->only('update');
        $this->middleware('permission:nationality-delete')->only('delete');
        $this->middleware('permission:nationality-status')->only('changeStatus');
        $this->service = $Service;
    }

    public function show($id)
    {
        $data = $this->service->show($id);
        if ($data) {
            return $this->apiResponse(new NationalityResource($data), 'Done');
        }
        return $this->unKnowError();
    }

    public function store(CreateRequest $request)
    {
        $data = $this->service->store($request);
        if ($data) {
            return $this->createResponse(new NationalityResource($data), 'create done');
        }
        return $this->unKnowError();
    }

    public function update(EditRequest $request, $id)
    {
        $data = $this->service->update($request,$id);
        if ($data) {
            return $this->updateResponse(new NationalityResource($data), 'update Done');
        }
        return $this->unKnowError();
    }

    public function index(Request $request)
    {
        return $this->apiResponse(NationalityListResource::collection($this->service->list($request,pagination: $this->pagination(),perPage: $this->perPage())), 'Done');
    }

}
