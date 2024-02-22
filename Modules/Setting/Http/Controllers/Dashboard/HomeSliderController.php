<?php

namespace Modules\Setting\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Modules\Basic\Http\Controllers\BasicController;
use Modules\Setting\Http\Requests\HomeSlider\Dashboard\CreateRequest;
use Modules\Setting\Http\Requests\HomeSlider\Dashboard\EditRequest;
use Modules\Setting\Http\Resources\HomeSlider\Dashboard\HomeSliderListResource;
use Modules\Setting\Http\Resources\HomeSlider\Dashboard\HomeSliderResource;
use Modules\Setting\Service\HomeSliderService;

class HomeSliderController extends BasicController
{
    public $service;

    public function __construct(HomeSliderService $Service)
    {
        $this->middleware('auth:dashboard');
        $this->middleware('permission:home-slider-show')->only(['index','show']);
        $this->middleware('permission:home-slider-create')->only('store');
        $this->middleware('permission:home-slider-edit')->only('update');
        $this->middleware('permission:home-slider-delete')->only('delete');
        $this->middleware('permission:home-slider-status')->only('changeStatus');
        $this->service = $Service;
    }

    public function show($id)
    {
        $data = $this->service->show($id);
        if ($data) {
            return $this->apiResponse(new HomeSliderResource($data), 'Done');
        }
        return $this->unKnowError();
    }

    public function store(CreateRequest $request)
    {
        $data = $this->service->store($request);
        if ($data) {
            return $this->createResponse(new HomeSliderResource($data), 'create done');
        }
        return $this->unKnowError();
    }

    public function update(EditRequest $request, $id)
    {
        $data = $this->service->update($request,$id);
        if ($data) {
            return $this->updateResponse(new HomeSliderResource($data), 'update Done');
        }
        return $this->unKnowError();
    }
    public function index(Request $request)
    {
        return $this->apiResponse(HomeSliderListResource::collection($this->service->list($request,pagination: $this->pagination(),perPage: $this->perPage())), 'Done');
    }

}
