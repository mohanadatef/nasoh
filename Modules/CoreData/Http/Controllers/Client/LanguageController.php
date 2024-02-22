<?php

namespace Modules\CoreData\Http\Controllers\Client;

use Illuminate\Http\Request;
use Modules\Basic\Http\Controllers\BasicController;
use Modules\CoreData\Http\Resources\Language\Client\LanguageResource;
use Modules\CoreData\Service\LanguageService;

class LanguageController extends BasicController
{
    public $service;

    public function __construct(LanguageService $Service)
    {
        $this->service = $Service;
    }
    public function list(Request $request)
    {
        return $this->apiResponse(LanguageResource::collection($this->service->list($request,pagination: $this->pagination(),perPage: $this->perPage())), 'Done');
    }
}
