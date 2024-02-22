<?php

namespace Modules\CoreData\Http\Controllers\Client;

use Illuminate\Http\Request;
use Modules\Basic\Http\Controllers\BasicController;
use Modules\CoreData\Http\Resources\Payment\Client\PaymentResource;
use Modules\CoreData\Service\PaymentService;

class PaymentController extends BasicController
{
    public $service;

    public function __construct(PaymentService $Service)
    {
        $this->middleware('auth:client');
        $this->service = $Service;
    }
    public function list(Request $request)
    {
        return $this->apiResponse(PaymentResource::collection($this->service->list($request,pagination: $this->pagination(),perPage: $this->perPage())), 'Done');
    }
}
