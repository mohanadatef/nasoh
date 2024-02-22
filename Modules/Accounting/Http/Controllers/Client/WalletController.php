<?php

namespace Modules\Accounting\Http\Controllers\Client;

use Modules\Accounting\Http\Resources\Wallet\Client\WalletListResource;
use Modules\Accounting\Service\WalletService;
use Modules\Basic\Http\Controllers\BasicController;

class WalletController extends BasicController
{
    protected $service;

    public function __construct(WalletService $Service)
    {
        $this->middleware('auth:client');
        $this->service = $Service;
    }
    public function show()
    {
        $data = $this->service->show(user('client')->wallet_id);
        if ($data) {
            return $this->apiResponse(new WalletListResource($data), 'Done');
        }
        return $this->unKnowError();
    }
}
