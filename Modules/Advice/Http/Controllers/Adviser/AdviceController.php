<?php

namespace Modules\Advice\Http\Controllers\Adviser;

use Illuminate\Http\Request;
use Modules\Advice\Http\Resources\Advice\Adviser\AdviceListResource;
use Modules\Advice\Http\Resources\Advice\Adviser\AdviceResource;
use Modules\Advice\Service\AdviceService;
use Modules\Basic\Http\Controllers\BasicController;

class AdviceController extends BasicController
{
    public function __construct(AdviceService $Service)
    {
        $this->middleware('auth:adviser');
        $this->service = $Service;
    }

    public function list(Request $request)
    {
        $request->merge(['adviser_id' => user('adviser')->id]);
        return $this->apiResponse(AdviceListResource::collection($this->service->list($request,
            pagination: $this->pagination(), perPage: $this->perPage(),
            moreConditionForFirstLevel: ['where' => ['label_id' => ['!=', 1]]])), 'Done');
    }

    public function show($id)
    {
        $data = $this->service->show($id);
        if($data->adviser_id == user('adviser')->id)
        {
            if($data)
            {
                return $this->updateResponse(new AdviceResource($data), 'done');
            }
        }
        return $this->unKnowError();
    }

    public function done($id)
    {
        $data = $this->service->show($id);
        if($data->label_id == 2 && $data->adviser_id == user('adviser')->id)
        {
            $data= $this->service->doneAdviser($id);
            if($data)
            {
                return $this->updateResponse(new AdviceResource($data), 'done done');
            }
        }
        return $this->unKnowError();
    }
    public function reject(Request $request, $id)
    {
        $data = $this->service->show($id);
        if($data->label_id == 2 && $data->adviser_id == user('adviser')->id)
        {
            $data=$this->service->rejectAdviser($request, $id);
            if($data)
            {
                return $this->updateResponse([], 'done done');
            }
        }
        return $this->unKnowError();
    }
}
