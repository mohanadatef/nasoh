<?php

namespace Modules\CoreData\Http\Controllers\Adviser;

use Illuminate\Http\Request;
use Modules\Basic\Http\Controllers\BasicController;
use Modules\CoreData\Http\Resources\Comment\Adviser\CommentResource;
use Modules\CoreData\Service\CommentService;

class CommentController extends BasicController
{
    public $service;

    public function __construct(CommentService $Service)
    {
        $this->middleware('auth:adviser');
        $this->service = $Service;
    }
    public function list(Request $request)
    {
        $request->merge(['type'=>'adviser']);
        $data=CommentResource::collection($this->service->list($request,pagination: $this->pagination(),perPage: $this->perPage()));
        $data=$data->push(['id'=>0,'name'=>'اخرى']);
        return $this->apiResponse($data, 'Done');
    }
}
