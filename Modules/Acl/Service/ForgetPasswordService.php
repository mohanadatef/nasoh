<?php

namespace Modules\Acl\Service;

use Illuminate\Http\Request;
use Modules\Basic\Service\BasicService;

class ForgetPasswordService extends BasicService
{
    protected $adviserService;

    public function __construct(AdviserService $adviserService)
    {
        $this->adviserService = $adviserService;
    }

    public function store(Request $request)
    {
        $user = $this->getUser($request);
        if($user)
        {
            return true;
        }
        return false;
    }

    public function check(Request $request)
    {
        $check = true;
        // $check = $this->checkOTP($request->country_code . $request->mobile, $request->code);
        if($check === "incorrect")
        {
            $check = 0;
        }
        if($check)
        {
            return ['result' => $check,'message' => 'done'];
        }
    }

    public function changePassword(Request $request)
    {
        $user = $this->getUser($request);
        if($user)
        {
            $newRequest = new Request($request->except(['mobile', 'status']));
            $newRequest->merge(['id' => $user->id]);
            $data = $this->adviserService->update($newRequest,$user->id);
            if($data)
            {
                return true;
            }
        }
        return false;
    }

    public function getUser(Request $request)
    {
        if(isset($request->id) || isset($request->mobile))
        {
            if($request->mobile)
            {
                $request->merge(['mobile' => $this->convertPersian($request->mobile)]);
            }
            return $this->adviserService->findBy($request, [], get:'first');
        }
        return null;
    }
}
