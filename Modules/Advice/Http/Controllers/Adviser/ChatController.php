<?php

namespace Modules\Advice\Http\Controllers\Adviser;

use Illuminate\Http\Request;
use Modules\Advice\Http\Resources\Chat\ChatResource;
use Modules\Advice\Service\ChatService;
use Modules\Basic\Http\Controllers\BasicController;

class ChatController extends BasicController
{
    public function __construct(ChatService $Service)
    {
        $this->middleware('auth:adviser');
        $this->service = $Service;
    }


    public function store(Request $request)
    {
        $request->merge(['adviser_id' => user('adviser')->id]);
        $data = $this->service->store($request);
        if($data)
        {
            return $this->createResponse(new ChatResource($data), 'create done');
        }
        return $this->unKnowError();
    }

}
