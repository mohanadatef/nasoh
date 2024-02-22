<?php

namespace Modules\CoreData\Http\Controllers\Adviser;

use Illuminate\Http\Request;
use Modules\Basic\Http\Controllers\BasicController;
use Modules\CoreData\Http\Resources\Category\Adviser\CategoryParentResource;
use Modules\CoreData\Http\Resources\Category\Adviser\CategoryResource;
use Modules\CoreData\Service\CategoryService;

class CategoryController extends BasicController
{
    public $service;

    public function __construct(CategoryService $Service)
    {
        $this->service = $Service;
    }

    public function list(Request $request)
    {
        return $this->apiResponse(CategoryResource::collection($this->service->list($request,pagination: $this->pagination(),perPage: $this->perPage())), 'Done');
    }

    public function listParent(Request $request)
    {
        $request->merge(['parent_id'=>0]);
        return $this->apiResponse(CategoryParentResource::collection($this->service->list($request,pagination: $this->pagination(),perPage: $this->perPage())), 'Done');
    }

}
