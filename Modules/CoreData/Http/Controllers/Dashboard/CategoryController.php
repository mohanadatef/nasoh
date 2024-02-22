<?php

namespace Modules\CoreData\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Modules\Basic\Http\Controllers\BasicController;
use Modules\CoreData\Http\Requests\Category\Dashboard\CreateRequest;
use Modules\CoreData\Http\Requests\Category\Dashboard\EditRequest;
use Modules\CoreData\Http\Resources\Category\Dashboard\CategoryListResource;
use Modules\CoreData\Http\Resources\Category\Dashboard\CategoryResource;
use Modules\CoreData\Http\Resources\Nationality\Dashboard\NationalityListResource;
use Modules\CoreData\Service\CategoryService;

class CategoryController extends BasicController
{
    public $service;

    public function __construct(CategoryService $Service)
    {
        $this->middleware('auth:dashboard');
        $this->middleware('permission:category-show')->only(['index','show']);
        $this->middleware('permission:category-create')->only('store');
        $this->middleware('permission:category-edit')->only('update');
        $this->middleware('permission:category-delete')->only('delete');
        $this->middleware('permission:category-status')->only('changeStatus');
        $this->service = $Service;
    }

    public function show($id)
    {
        $data = $this->service->show($id);
        if ($data) {
            return $this->apiResponse(new CategoryResource($data), 'Done');
        }
        return $this->unKnowError();
    }

    public function store(CreateRequest $request)
    {
        $data = $this->service->store($request);
        if ($data) {
            return $this->createResponse(new CategoryResource($data), 'create done');
        }
        return $this->unKnowError();
    }

    public function update(EditRequest $request, $id)
    {
        $data = $this->service->update($request,$id);
        if ($data) {
            return $this->updateResponse(new CategoryResource($data), 'update Done');
        }
        return $this->unKnowError();
    }
    public function index(Request $request)
    {
        return $this->apiResponse(CategoryListResource::collection($this->service->list($request,pagination: $this->pagination(),perPage: $this->perPage())), 'Done');
    }
}
