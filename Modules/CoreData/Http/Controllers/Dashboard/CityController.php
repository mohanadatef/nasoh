<?php

namespace Modules\CoreData\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Modules\Basic\Http\Controllers\BasicController;
use Modules\CoreData\Http\Requests\city\Dashboard\CreateRequest;
use Modules\CoreData\Http\Requests\city\Dashboard\EditRequest;
use Modules\CoreData\Http\Resources\City\Adviser\cityResource;
use Modules\CoreData\Http\Resources\City\Dashboard\CityListResource;
use Modules\CoreData\Service\cityService;

class CityController extends BasicController
{
    public $service;

    public function __construct(cityService $Service)
    {
        $this->middleware('auth:dashboard');
        $this->middleware('permission:city-show')->only(['index','show']);
        $this->middleware('permission:city-create')->only('store');
        $this->middleware('permission:city-edit')->only('update');
        $this->middleware('permission:city-delete')->only('delete');
        $this->middleware('permission:city-status')->only('changeStatus');
        $this->service = $Service;
    }

    public function show($id)
    {
        $data = $this->service->show($id);
        if ($data) {
            return $this->apiResponse(new cityResource($data), 'Done');
        }
        return $this->unKnowError();
    }

    public function store(CreateRequest $request)
    {
        $data = $this->service->store($request);
        if ($data) {
            return $this->createResponse(new cityResource($data), 'create done');
        }
        return $this->unKnowError();
    }

    public function update(EditRequest $request, $id)
    {
        $data = $this->service->update($request,$id);
        if ($data) {
            return $this->updateResponse(new cityResource($data), 'update Done');
        }
        return $this->unKnowError();
    }

    public function index(Request $request)
    {
        return $this->apiResponse(CityListResource::collection($this->service->list($request,pagination: $this->pagination(),perPage: $this->perPage())), 'Done');
    }

}
