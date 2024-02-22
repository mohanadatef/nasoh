<?php

namespace Modules\CoreData\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Modules\Basic\Http\Controllers\BasicController;
use Modules\CoreData\Http\Requests\Country\Dashboard\CreateRequest;
use Modules\CoreData\Http\Requests\Country\Dashboard\EditRequest;
use Modules\CoreData\Http\Resources\Country\Dashboard\CountryListResource;
use Modules\CoreData\Http\Resources\Country\Dashboard\CountryResource;
use Modules\CoreData\Service\CountryService;

class CountryController extends BasicController
{
    public $service;

    public function __construct(CountryService $Service)
    {
        $this->middleware('auth:dashboard');
        $this->middleware('permission:country-show')->only(['index','show']);
        $this->middleware('permission:country-create')->only('store');
        $this->middleware('permission:country-edit')->only('update');
        $this->middleware('permission:country-delete')->only('delete');
        $this->middleware('permission:country-status')->only('changeStatus');
        $this->service = $Service;
    }

    public function show($id)
    {
        $data = $this->service->show($id);
        if ($data) {
            return $this->apiResponse(new CountryResource($data), 'Done');
        }
        return $this->unKnowError();
    }

    public function store(CreateRequest $request)
    {
        $data = $this->service->store($request);
        if ($data) {
            return $this->createResponse(new CountryResource($data), 'create done');
        }
        return $this->unKnowError();
    }

    public function update(EditRequest $request, $id)
    {
        $data = $this->service->update($request,$id);
        if ($data) {
            return $this->updateResponse(new CountryResource($data), 'update Done');
        }
        return $this->unKnowError();
    }
    public function index(Request $request)
    {
        return $this->apiResponse(CountryListResource::collection($this->service->list($request,pagination: $this->pagination(),perPage: $this->perPage())), 'Done');
    }

}
