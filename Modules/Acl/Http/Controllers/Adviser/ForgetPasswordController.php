<?php

namespace Modules\Acl\Http\Controllers\Adviser;

use Illuminate\Http\Request;
use Modules\Acl\Http\Requests\Adviser\Adviser\changePasswordRequest;
use Modules\Acl\Service\ForgetPasswordService;
use Modules\Basic\Http\Controllers\BasicController;

class ForgetPasswordController extends BasicController
{
    private $service;

    public function __construct(ForgetPasswordService $Service)
    {
        $this->service = $Service;
    }

    public function store(Request $request)
    {
       $data = $this->service->store($request);
       if($data){
           return $this->createResponse(null,'code_send');
       }
       return $this->unKnowError('failed');
    }

    public function check(Request $request)
    {
        $data = $this->service->check($request);
        if ($data && isset($data['result'])) {
            if ($data['result'] != false) {
                return $this->apiResponse([], $data['message']);
            } else {
                return $this->unKnowError($data['message']);
            }
        }
        return $this->unKnowError('failed');
    }

    public function changePassword(changePasswordRequest $request)
    {
        $data = $this->service->changePassword($request);
        if ($data) {
            return $this->updateResponse(null, 'password_change');
        }
        return $this->unKnowError();
    }
}
