<?php

namespace Modules\Acl\Service;

use Illuminate\Http\Request;
use Modules\Basic\Service\BasicService;

class RegisterMobileService extends BasicService
{
    protected $adviserService,$clientService;

    public function __construct(AdviserService $adviserService,ClientService $clientService)
    {
        $this->adviserService = $adviserService;
        $this->clientService = $clientService;
    }

    public function store(Request $request, $type = null)
    {
        $data = null;
        if ($type === 'client') {
            $data = $this->clientService->findBy($request, get: 'count');
        } elseif ($type === 'adviser') {
            $data = $this->adviserService->findBy($request, get: 'count');
        }

        if ($data === 0 || $type === 'client') {
              $this->sendOTP($request->country_code . $request->mobile);
            return ['result' => true, 'data' => []];
        }
        return ['result' => false, 'message' => 'this_mobile_used'];
    }

    public function check(Request $request,$type = null)
    {
        $check = true;
        $check = $this->checkOTP($request->country_code .$request->mobile, $request->code);
        if ($check == "incorrect") {
            $check = 0;
        }
        $check = true;
        if ($check) {
            $data = ['result' => $check, 'message' => 'done'];
            if($type=='client')
            {
                $count = $this->clientService->findBy($request, get: 'count');
                $data['data']= ['login'=>$count ? 1 : 0];
            }
            return $data;
        }
        return false;
    }

    public function resend(Request $request)
    {
        $adviser = $this->adviserService->findBy(new Request(['mobile' => $request->mobile]), get: 'first');
        if (!$adviser) {
             $this->sendOTP($request->country_code .$request->mobile);
            return true;
        }
        return false;
    }
}
