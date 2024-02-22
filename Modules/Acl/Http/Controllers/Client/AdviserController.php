<?php

namespace Modules\Acl\Http\Controllers\Client;

use Illuminate\Http\Request;
use Modules\Acl\Http\Resources\Adviser\Client\AdviserListResource;
use Modules\Acl\Http\Resources\Adviser\Client\AdviserProfileResource;
use Modules\Acl\Service\ClientService;
use Modules\Basic\Http\Controllers\BasicController;

class AdviserController extends BasicController
{
    protected $service;

    public function __construct(ClientService $Service)
    {
        $this->service = $Service;
    }

    public function list(Request $request)
    {
        $moreConditionForFirstLevel = [];
        $recursiveRel = [];
        if(isset($request->name) && !empty($request->name))
        {
            $recursiveRel = [
                'adviser_category' => [
                    'type' => 'whereHas',
                    'recursive' => [
                        'category' => [
                            'type' => 'whereHas',
                            'recursive' => [
                                'name' => [
                                    'type' => 'whereHas',
                                    'orWhere' => ['value' => ['like','%'.$request->name.'%']],
                                ]
                            ]
                        ]
                    ]
                ]
            ];
            $moreConditionForFirstLevel = [
                'whereCustom' => [
                    'orWhere' => [
                        ['full_name' => ['like','%'.$request->name.'%']], ['info' => ['like','%'.$request->name.'%']]
                    ]],
            ];
        }
        return $this->apiResponse(AdviserListResource::collection($this->service->adviserList($request,
            pagination: $this->pagination(), perPage: $this->perPage(), recursiveRel: $recursiveRel,moreConditionForFirstLevel:$moreConditionForFirstLevel)), 'Done');
    }

    public function profile($id)
    {
        $data = $this->service->adviserProfile($id);
        if($data)
        {
            return $this->apiResponse(new AdviserProfileResource($data), 'Done');
        }
        return $this->apiResponse([], 'Done');
    }
}
