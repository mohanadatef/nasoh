<?php

namespace Modules\Setting\Http\Controllers\Adviser;

use Illuminate\Http\Request;
use Modules\Basic\Http\Controllers\BasicController;
use Modules\Setting\Http\Resources\Notification\Adviser\NotificationResource;
use Modules\Setting\Service\NotificationService;

class NotificationController extends BasicController
{
    private $service;

    public function __construct(NotificationService $Service)
    {
        $this->middleware('auth:adviser');
        $this->service = $Service;
    }

    public function list(Request $request)
    {
        $request->merge(['receiver_id' => user('adviser')->id,'type'=>'adviser']);
        return $this->apiResponse(NotificationResource::collection($this->service->list($request, $this->pagination(), $this->perPage())), 'Done');
    }

    public function read($id)
    {
        $data = $this->service->readNotification($id);
        if($data)
        {
            return $this->apiResponse(new NotificationResource($data), 'Done');
        }
        return $this->unKnowError('problem');
    }
}
