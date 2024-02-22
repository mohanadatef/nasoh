<?php

namespace Modules\Acl\Http\Controllers\Dashboard;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Modules\Acl\Http\Requests\Login\Dashboard\LoginRequest;
use Modules\Acl\Http\Resources\User\Dashboard\UserLoginResource;
use Modules\Acl\Http\Resources\User\Dashboard\UserResource;
use Modules\Acl\Service\UserService;
use Modules\Basic\Http\Controllers\BasicController;

/**
 * @extends BasicController
 * controller auth for login and auth function
 */
class AuthController extends BasicController
{
    protected  $userService;

    public function __construct( UserService $userService)
    {
        $this->middleware('auth:dashboard', ['except' => ['login']]);
        $this->userService = $userService;
    }

    /**
     * @param Request $request
     * can login by mobile or email or username
     * @must by status => active 1,make confirm email , approve by admin
     */
    public function login(LoginRequest $request)
    {
        $user = $this->userService->findBy(new Request(['email' => $request->email]), get:'first');
        if ($user) {
            if (!Hash::check($request->password, $user->password)) {
                return $this->unauthorizedResponse('failed_password');
            }
            if(!$user->status)
            {
                return $this->unauthorizedResponse('call support');
            }
            $token = $user->createToken('nasooh dashboard')->accessToken;
            $user->update(['token' => $token]);
            if ($request->device) {
                $user->device()->firstOrCreate(['device' => $request->device]);
            }
            return $this->apiResponse(new UserLoginResource($user), 'login');
        } else {
            return $this->unauthorizedResponse('failed');
        }
    }

    public function logout(Request $request)
    {
        user('dashboard')->token()->revoke();
        if ($request->device)
        {
            user('dashboard')->device()->firstOrCreate(['device' => $request->device])->delete();
        }
        $this->userService->findBy(new Request(['id' => user('dashboard')->id]), get:'first')->update(['token'=>null]);
        return $this->apiResponse([], 'logout done');
    }

    /**
     * check if header have token so send data for user login
     */
    public function getUserByToken()
    {
        if (user('dashboard')) {
            return $this->apiResponse(new UserLoginResource(user('dashboard')), 'done');
        }
        return $this->unauthorizedResponse('failed');
    }
}
