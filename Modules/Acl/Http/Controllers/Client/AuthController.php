<?php

namespace Modules\Acl\Http\Controllers\Client;


use Illuminate\Http\Request;
use Modules\Acl\Http\Resources\Client\Client\ClientLoginResource;
use Modules\Acl\Http\Resources\Client\Dashboard\ClientResource;
use Modules\Acl\Service\ClientService;
use Modules\Basic\Http\Controllers\BasicController;
use Modules\Basic\Traits\validationRulesTrait;

/**
 * @extends BasicController
 * controller auth for login and auth function
 */
class AuthController extends BasicController
{
    use validationRulesTrait;
    protected  $clientService;

    public function __construct( ClientService $clientService)
    {
        $this->middleware('auth:client', ['except' => ['getUserByMobile','getUserByToken']]);
        $this->clientService = $clientService;
    }

    /**
     * @param Request $request
     * can login by mobile or email or clientname
     * @must by status => active 1,make confirm email , approve by admin
     */
    public function getUserByMobile(Request $request)
    {
        $request->merge(['mobile' => $this->convertPersian($request->mobile)]);
        $client = $this->clientService->findBy(new Request(['mobile' => $request->mobile]), get:'first');
        if ($client) {
            if(!$client->status)
            {
                return $this->unauthorizedResponse('call support');
            }
            $token = $client->createToken('nasooh client')->accessToken;
            $client->update(['token' => $token]);
            if ($request->device) {
                $client->device()->firstOrCreate(['device' => $request->device]);
            }
            return $this->apiResponse(new ClientLoginResource($client), 'login');
        }
        return $this->unauthorizedResponse('failed');
    }

    public function logout(Request $request)
    {
        user('client')->token()->revoke();
        if ($request->device)
        {
            user('client')->device()->firstOrCreate(['device' => $request->device])->delete();
        }
        $this->clientService->findBy(new Request(['id' => user('client')->id]), get:'first')->update(['token'=>null]);
        return $this->apiResponse([], 'logout done');
    }

    /**
     * check if header have token so send data for client login
     */
    public function getUserByToken()
    {
        if (user('client')) {
            return $this->apiResponse(new ClientLoginResource(user('client')), 'done');
        }
        return $this->unauthorizedResponse('failed');
    }
}
