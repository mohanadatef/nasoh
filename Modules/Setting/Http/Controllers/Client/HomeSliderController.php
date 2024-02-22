<?php

namespace Modules\Setting\Http\Controllers\Client;

use Illuminate\Http\Request;
use Modules\Basic\Http\Controllers\BasicController;
use Modules\Setting\Service\HomeSliderService;
use Modules\Setting\Http\Resources\HomeSlider\Client\HomeSliderListResource;

class HomeSliderController extends BasicController
{
    public $service;

    public function __construct(HomeSliderService $Service)
    {
        $this->middleware('auth:client');
        $this->service = $Service;
    }

    public function list(Request $request)
    {
        return $this->apiResponse(HomeSliderListResource::collection($this->service->list($request, $this->pagination(), $this->perPage())), 'Done');
    }

}
