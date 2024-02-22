<?php

namespace Modules\CoreData\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Modules\Basic\Http\Controllers\BasicController;
use Modules\CoreData\Http\Requests\Comment\Dashboard\CreateRequest;
use Modules\CoreData\Http\Requests\Comment\Dashboard\EditRequest;
use Modules\CoreData\Http\Resources\Comment\Dashboard\CommentListResource;
use Modules\CoreData\Http\Resources\Comment\Dashboard\CommentResource;
use Modules\CoreData\Service\CommentService;

class CommentController extends BasicController
{
    public $service;

    public function __construct(CommentService $Service)
    {
        $this->middleware('auth:dashboard');
        $this->middleware('permission:comment-show')->only(['index','show']);
        $this->middleware('permission:comment-create')->only('store');
        $this->middleware('permission:comment-edit')->only('update');
        $this->middleware('permission:comment-delete')->only('delete');
        $this->middleware('permission:comment-status')->only('changeStatus');
        $this->service = $Service;
    }

    public function show($id)
    {
        $data = $this->service->show($id);
        if ($data) {
            return $this->apiResponse(new CommentResource($data), 'Done');
        }
        return $this->unKnowError();
    }

    public function store(CreateRequest $request)
    {
        $data = $this->service->store($request);
        if ($data) {
            return $this->createResponse(new CommentResource($data), 'create done');
        }
        return $this->unKnowError();
    }

    public function update(EditRequest $request, $id)
    {
        $data = $this->service->update($request,$id);
        if ($data) {
            return $this->updateResponse(new CommentResource($data), 'update Done');
        }
        return $this->unKnowError();
    }
    public function index(Request $request)
    {
        return $this->apiResponse(CommentListResource::collection($this->service->list($request,pagination: $this->pagination(),perPage: $this->perPage())), 'Done');
    }
}
