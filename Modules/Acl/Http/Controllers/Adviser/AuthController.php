<?php

namespace Modules\Acl\Http\Controllers\Adviser;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Modules\Acl\Http\Requests\Login\Adviser\LoginRequest;
use Modules\Acl\Http\Resources\Adviser\Adviser\AdviserLoginResource;
use Modules\Acl\Service\AdviserService;
use Modules\Basic\Http\Controllers\BasicController;

/**
 * @extends BasicController
 * controller auth for login and auth function
 */
class AuthController extends BasicController
{
    protected  $adviserService;

    public function __construct( AdviserService $adviserService)
    {
        $this->middleware('auth:adviser', ['except' => ['login','getUserByToken']]);
        $this->adviserService = $adviserService;
    }

    /**
     * @param Request $request
     * can login by mobile or email or advisername
     * @must by status => active 1,make confirm email , approve by admin
     */
    public function login(LoginRequest $request)
    {
        $adviser = $this->adviserService->findBy(new Request(['mobile' => $request->mobile]), get:'first');
        if ($adviser) {
            if (!Hash::check($request->password, $adviser->password)) {
                return $this->unauthorizedResponse('failed password');
            }
            if(!$adviser->status)
            {
                return $this->unauthorizedResponse('call support');
            }
            $token = $adviser->createToken('nasooh adviser')->accessToken;
            $adviser->update(['token' => $token]);
            if ($request->device) {
                $adviser->device()->firstOrCreate(['device' => $request->device]);
            }
            return $this->apiResponse(new AdviserLoginResource($adviser), 'login');
        } else {
            return $this->unauthorizedResponse('failed');
        }
    }

    public function logout(Request $request)
    {
        user('adviser')->token()->revoke();
        if ($request->device)
        {
            user('adviser')->device()->firstOrCreate(['device' => $request->device])->delete();
        }
        $this->adviserService->findBy(new Request(['id' => user('adviser')->id]), get:'first')->update(['token'=>null]);
        return $this->apiResponse([], 'logout done');
    }

    /**
     * check if header have token so send data for adviser login
     */
    public function getUserByToken()
    {
        if (user('adviser')) {
            return $this->apiResponse(new AdviserLoginResource(user('adviser')), 'done');
        }
        return $this->unauthorizedResponse('failed');
    }
}
