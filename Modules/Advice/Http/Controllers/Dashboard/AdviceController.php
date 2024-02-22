<?php

namespace Modules\Advice\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Modules\Advice\Http\Resources\Advice\Dashboard\AdviserListResource;
use Modules\Advice\Http\Resources\Advice\Dashboard\Report\AdviserReportResource;
use Modules\Advice\Service\AdviceService;
use Modules\Basic\Http\Controllers\BasicController;

class AdviceController extends BasicController
{
    protected $service;

    public function __construct(AdviceService $Service)
    {
        $this->middleware('auth:dashboard');
        $this->middleware('permission:advice-show')->only(['index', 'show', 'report']);
        $this->service = $Service;
    }

    public function index(Request $request)
    {
        return $this->apiResponse(AdviserListResource::collection($this->service->list($request, $this->pagination(),
            $this->perPage())), 'Done');
    }

    public function report(Request $request)
    {
        $total = $this->service->findBy($request,get:'count');
        $complete = $this->service->findBy(new Request(['status_id'=>1]),get:'count');
        $reject = $this->service->findBy(new Request(['status_id'=>2]),get:'count');
        $objector = $this->service->findBy(new Request(['status_id'=>3]),get:'count');
        $data = ['total' => $total, 'complete' => $complete, 'reject' => $reject, 'objector' => $objector];
        return $this->apiResponse(new AdviserReportResource($data), 'Done');
    }
}
