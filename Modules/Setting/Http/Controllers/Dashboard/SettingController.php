<?php

namespace Modules\Setting\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Modules\Basic\Http\Controllers\BasicController;
use Modules\Setting\Http\Requests\Setting\Dashboard\EditRequest;
use Modules\Setting\Http\Resources\Setting\Dashboard\SettingResource;
use Modules\Setting\Service\SettingService;

class SettingController extends BasicController
{
    public $service;

    public function __construct(SettingService $Service)
    {
        $this->middleware('auth:dashboard');
        $this->middleware('permission:setting-show')->only('list');
        $this->middleware('permission:setting-edit')->only('update');
        $this->service = $Service;
    }

    public function list(Request $request)
    {
        return $this->apiResponse(SettingResource::collection($this->service->list($request,pagination: $this->pagination(),perPage: $this->perPage())), 'Done');
    }

    public function update(EditRequest $request)
    {
        $data = $this->service->store($request);
        if ($data) {
            return $this->updateResponse([], 'update Done');
        }
        return $this->unKnowError();
    }

}
