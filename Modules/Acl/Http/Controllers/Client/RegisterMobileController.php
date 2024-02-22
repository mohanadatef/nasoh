<?php

namespace Modules\Acl\Http\Controllers\Client;

use Illuminate\Http\Request;
use Modules\Acl\Http\Requests\RegisterMobile\Client\CheckMobileRequest;
use Modules\Acl\Service\RegisterMobileService;
use Modules\Basic\Http\Controllers\BasicController;
use Modules\Basic\Traits\validationRulesTrait;

class RegisterMobileController extends BasicController
{
    use validationRulesTrait;

    private $service;

    public function __construct(RegisterMobileService $Service)
    {
        $this->service = $Service;
    }

    public function store(Request $request)
    {
        $request->merge(['mobile' => $this->convertPersian($request->mobile)]);
        $data = $this->service->store($request, 'client');
        if($data['result'] == true)
        {
            return $this->createResponse($data['data'], 'code_send');
        }
        return $this->unKnowError('this mobile use before');
    }

    public function check(CheckMobileRequest $request)
    {
        $data = $this->service->check($request, 'client');
        if($data && $data['result'] !== false)
        {
            return $this->apiResponse($data['data'], $data['message']);
        }
        return $this->unKnowError($data['message'] ?? 'failed');
    }

    public function resend(Request $request)
    {
        $data = $this->service->resend($request);
        if($data)
        {
            return $this->createResponse([], 'code_send');
        }
        return $this->unKnowError('failed');
    }
}
