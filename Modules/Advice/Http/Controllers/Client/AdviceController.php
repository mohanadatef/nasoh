<?php

namespace Modules\Advice\Http\Controllers\Client;

use Illuminate\Http\Request;
use Modules\Advice\Http\Requests\Advice\Client\CreateRequest;
use Modules\Advice\Http\Requests\Advice\Client\ReviewRequest;
use Modules\Advice\Http\Resources\Advice\Client\AdviceListResource;
use Modules\Advice\Http\Resources\Advice\Client\AdviceResource;
use Modules\Advice\Service\AdviceService;
use Modules\Basic\Http\Controllers\BasicController;

class AdviceController extends BasicController
{
    public function __construct(AdviceService $Service)
    {
        $this->middleware('auth:client');
        $this->service = $Service;
    }

    public function list(Request $request)
    {
        $request->merge(['client_id' => user('client')->id]);
        return $this->apiResponse(AdviceListResource::collection($this->service->list($request)), 'Done');
    }

    public function store(CreateRequest $request)
    {
        $data = $this->service->store($request);
        if($data)
        {
            return $this->createResponse(new AdviceResource($data), 'create done');
        }
        return $this->unKnowError();
    }

    public function show($id)
    {
        $data = $this->service->show($id);
        if($data && $data->client_id == user('client')->id)
        {
            return $this->apiResponse(new AdviceResource($data), 'done');
        }
        return $this->unKnowError();
    }

    public function pay(Request $request, $id)
    {
        $data = $this->service->pay($request, $id);
        if(isset($data['status']) && $data['status'] == false)
        {
            return $this->unKnowError($data['message']);
        }elseif($data)
        {
            return $this->updateResponse(new AdviceResource($data), 'create done');
        }
        return $this->unKnowError();
    }

    public function done($id)
    {
        $data = $this->service->show($id);
        if($data->label_id == 3 && $data->client_id == user('client')->id)
        {
            $data=$this->service->doneClient($id);
            if($data)
            {
                return $this->updateResponse(new AdviceResource($data), 'done done');
            }
        }
        return $this->unKnowError();
    }

    public function review(ReviewRequest $request, $id)
    {
        $data = $this->service->show($id);
        if($data->label_id == 4 && $data->client_id == user('client')->id)
        {
            $data=$this->service->review($request, $id);
            if($data)
            {
                return $this->updateResponse([], 'done done');
            }
        }
        return $this->unKnowError();
    }

    public function reject(Request $request, $id)
    {
        $data = $this->service->show($id);
        if($data->label_id == 3 && $data->client_id == user('client')->id)
        {
            $data=$this->service->rejectClient($request, $id);
            if($data)
            {
                return $this->updateResponse([], 'done done');
            }
        }
        return $this->unKnowError();
    }
}
