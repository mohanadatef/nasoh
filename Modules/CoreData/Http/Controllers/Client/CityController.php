<?php

namespace Modules\CoreData\Http\Controllers\Client;

use Illuminate\Http\Request;
use Modules\Basic\Http\Controllers\BasicController;
use Modules\CoreData\Http\Resources\City\Client\CityResource;
use Modules\CoreData\Service\CityService;

class CityController extends BasicController
{
    public $service;

    public function __construct(CityService $Service)
    {
        $this->service = $Service;
    }

    public function list(Request $request)
    {
        return $this->apiResponse(CityResource::collection($this->service->list($request,pagination: $this->pagination(),perPage: $this->perPage())), 'Done');
    }

}
