<?php

namespace Modules\Setting\Http\Controllers\Adviser;

use Illuminate\Http\Request;
use Modules\Basic\Http\Controllers\BasicController;
use Modules\Setting\Http\Resources\Setting\Client\SettingResource;
use Modules\Setting\Service\SettingService;

class SettingController extends BasicController
{
    public $service;

    public function __construct(SettingService $Service)
    {
        $this->middleware('auth:adviser');
        $this->service = $Service;
    }

    public function support(Request $request)
    {
        $request->merge(['key'=>'support_adviser']);
        $data = $this->service->findBy($request, get:'first');
        if($data)
        {
            return $this->apiResponse(new SettingResource($this->service->findBy($request, get:'first')), 'Done');
        }
        return $this->apiResponse([], 'Done');
    }

}
