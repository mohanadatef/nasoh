<?php

namespace Modules\CoreData\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Modules\Basic\Http\Controllers\BasicController;
use Modules\CoreData\Http\Requests\Payment\Dashboard\CreateRequest;
use Modules\CoreData\Http\Requests\Payment\Dashboard\EditRequest;
use Modules\CoreData\Http\Resources\Payment\Dashboard\PaymentListResource;
use Modules\CoreData\Http\Resources\Payment\Dashboard\PaymentResource;
use Modules\CoreData\Service\PaymentService;

class PaymentController extends BasicController
{
    public $service;

    public function __construct(PaymentService $Service)
    {
        $this->middleware('auth:dashboard');
        $this->middleware('permission:payment-show')->only(['index','show']);
        $this->middleware('permission:payment-create')->only('store');
        $this->middleware('permission:payment-edit')->only('update');
        $this->middleware('permission:payment-delete')->only('delete');
        $this->middleware('permission:payment-status')->only('changeStatus');
        $this->service = $Service;
    }

    public function show($id)
    {
        $data = $this->service->show($id);
        if ($data) {
            return $this->apiResponse(new PaymentResource($data), 'Done');
        }
        return $this->unKnowError();
    }

    public function store(CreateRequest $request)
    {
        $data = $this->service->store($request);
        if ($data) {
            return $this->createResponse(new PaymentResource($data), 'create done');
        }
        return $this->unKnowError();
    }

    public function update(EditRequest $request, $id)
    {
        $data = $this->service->update($request,$id);
        if ($data) {
            return $this->updateResponse(new PaymentResource($data), 'update Done');
        }
        return $this->unKnowError();
    }

    public function index(Request $request)
    {
        return $this->apiResponse(PaymentListResource::collection($this->service->list($request,pagination: $this->pagination(),perPage: $this->perPage())), 'Done');
    }

}
