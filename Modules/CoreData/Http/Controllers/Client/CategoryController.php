<?php

namespace Modules\CoreData\Http\Controllers\Client;

use Illuminate\Http\Request;
use Modules\Basic\Http\Controllers\BasicController;
use Modules\CoreData\Http\Resources\Category\Client\CategoryParentResource;
use Modules\CoreData\Http\Resources\Category\Client\CategoryResource;
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
        $data=CategoryResource::collection($this->service->list($request,pagination: $this->pagination(),perPage: $this->perPage()));
        $data=$data->prepend(['id'=>0,'name'=>'الكل','children'=>[],'parent_id'=>0]);
        return $this->apiResponse($data, 'Done');
    }

    public function listParent(Request $request)
    {
        $request->merge(['parent_id'=>0]);
        $data=CategoryParentResource::collection($this->service->list($request,pagination: $this->pagination(),perPage: $this->perPage()));
        $data=$data->prepend(['id'=>0,'name'=>'الكل']);
        return $this->apiResponse($data, 'Done');
    }

}
