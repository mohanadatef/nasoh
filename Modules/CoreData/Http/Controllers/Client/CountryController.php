<?php

namespace Modules\CoreData\Http\Controllers\Client;

use Illuminate\Http\Request;
use Modules\Basic\Http\Controllers\BasicController;
use Modules\CoreData\Http\Resources\Country\Client\CountryResource;
use Modules\CoreData\Service\CountryService;

class CountryController extends BasicController
{
    public $service;

    public function __construct(CountryService $Service)
    {
        $this->service = $Service;
    }
    public function list(Request $request)
    {
        return $this->apiResponse(CountryResource::collection($this->service->list($request,pagination: $this->pagination(),perPage: $this->perPage())), 'Done');
    }
}
