<?php

namespace Modules\Setting\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Modules\Basic\Http\Controllers\BasicController;
use Modules\Setting\Http\Requests\Page\Dashboard\CreateRequest;
use Modules\Setting\Http\Requests\Page\Dashboard\EditRequest;
use Modules\Setting\Http\Resources\Page\Dashboard\PageListResource;
use Modules\Setting\Http\Resources\Page\Dashboard\PageResource;
use Modules\Setting\Service\PageService;

class PageController extends BasicController
{
    public $service;

    public function __construct(PageService $Service)
    {
        $this->middleware('auth:dashboard');
        $this->middleware('permission:page-show')->only(['index','show']);
        $this->middleware('permission:page-create')->only('store');
        $this->middleware('permission:page-edit')->only('update');
        $this->middleware('permission:page-delete')->only('delete');
        $this->middleware('permission:page-status')->only('changeStatus');
        $this->service = $Service;
    }

    public function show($id)
    {
        $data = $this->service->show($id);
        if ($data) {
            return $this->apiResponse(new PageResource($data), 'Done');
        }
        return $this->unKnowError();
    }

    public function store(CreateRequest $request)
    {
        $data = $this->service->store($request);
        if ($data) {
            return $this->createResponse(new PageResource($data), 'create done');
        }
        return $this->unKnowError();
    }

    public function update(EditRequest $request, $id)
    {
        $data = $this->service->update($request,$id);
        if ($data) {
            return $this->updateResponse(new PageResource($data), 'update Done');
        }
        return $this->unKnowError();
    }
    public function index(Request $request)
    {
        return $this->apiResponse(PageListResource::collection($this->service->list($request,pagination: $this->pagination(),perPage: $this->perPage())), 'Done');
    }

}
