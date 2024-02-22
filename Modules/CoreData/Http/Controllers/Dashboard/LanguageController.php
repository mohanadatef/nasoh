<?php

namespace Modules\CoreData\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Modules\Basic\Http\Controllers\BasicController;
use Modules\CoreData\Http\Requests\Language\Dashboard\CreateRequest;
use Modules\CoreData\Http\Requests\Language\Dashboard\EditRequest;
use Modules\CoreData\Http\Resources\Language\Dashboard\LanguageListResource;
use Modules\CoreData\Http\Resources\Language\Dashboard\LanguageResource;
use Modules\CoreData\Service\LanguageService;

class LanguageController extends BasicController
{
    public $service;

    public function __construct(LanguageService $Service)
    {
        $this->middleware('auth:dashboard')->except(['language']);
        $this->middleware('permission:language-show')->only(['index','show']);
        $this->middleware('permission:language-create')->only('store');
        $this->middleware('permission:language-edit')->only('update');
        $this->middleware('permission:language-delete')->only('delete');
        $this->middleware('permission:language-status')->only('changeStatus');
        $this->service = $Service;
    }

    public function show($id)
    {
        $data = $this->service->show($id);
        if ($data) {
            return $this->apiResponse(new LanguageResource($data), 'Done');
        }
        return $this->unKnowError();
    }

    public function store(CreateRequest $request)
    {
        $data = $this->service->store($request);
        if ($data) {
            return $this->createResponse(new LanguageResource($data), 'create done');
        }
        return $this->unKnowError();
    }

    public function update(EditRequest $request, $id)
    {
        $data = $this->service->update($request,$id);
        if ($data) {
            return $this->updateResponse(new LanguageResource($data), 'update Done');
        }
        return $this->unKnowError();
    }
    public function index(Request $request)
    {
        return $this->apiResponse(LanguageListResource::collection($this->service->list($request,pagination: $this->pagination(),perPage: $this->perPage())), 'Done');
    }

}
