<?php

namespace Modules\Accounting\Http\Controllers\Adviser;

use Modules\Accounting\Http\Resources\Wallet\Adviser\WalletListResource;
use Modules\Accounting\Service\WalletService;
use Modules\Basic\Http\Controllers\BasicController;

class WalletController extends BasicController
{
    protected $service;

    public function __construct(WalletService $Service)
    {
        $this->middleware('auth:adviser');
        $this->service = $Service;
    }
    public function show()
    {
        $data = $this->service->show(user('adviser')->wallet_id ?? 0);
        if ($data) {
            return $this->apiResponse(new WalletListResource($data), 'Done');
        }
        return $this->unKnowError();
    }
}
