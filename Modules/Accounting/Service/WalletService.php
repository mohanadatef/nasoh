<?php

namespace Modules\Accounting\Service;

use Illuminate\Http\Request;
use Modules\Accounting\Repositories\WalletRepository;
use Modules\Basic\Service\BasicService;

class WalletService extends BasicService
{
    protected $repo, $transactionService;

    /**
     * Create a new Repository instance.
     *
     * @return void
     */
    public function __construct(WalletRepository $repository, TransactionService $transactionService)
    {
        $this->repo = $repository;
        $this->transactionService = $transactionService;
    }

    public function payAdvice($data)
    {
        $this->payPrice($data);
        $this->addWaitPrice($data);
        $this->payTax($data);
        $this->addWaitTax($data);
    }

    public function payTax($data)
    {
        $balance = round($data->price * ($data->tax / 100),2);
        $wallet= $this->show(user('client')->wallet_id);
        $after = $wallet->balance - $balance;
        $this->repo->save(new Request(['balance'=>$after]), $wallet->id);
        $this->transactionService->store(new Request(['wallet_id' =>$wallet->id, 'before' => $wallet->balance,
            'balance' => $balance, 'key' => 'sub_tax_balance_client_key', 'after' => $after,'advice_id'=>$data->id]));
    }

    public function payPrice($data)
    {
        $balance = $data->price;
        $wallet= $this->show(user('client')->wallet_id);
        $after = $wallet->balance - $balance;
        $this->repo->save(new Request(['balance'=>$after]), $wallet->id);
        $this->transactionService->store(new Request(['wallet_id' =>$wallet->id, 'before' => $wallet->balance,
            'balance' => $balance, 'key' => 'sub_advice_balance_client_key', 'after' => $after,'advice_id'=>$data->id]));
    }

    public function addWaitTax($data)
    {
        $balance = round($data->price * ($data->tax / 100),2);
        $wallet= $this->repo->findBy(new Request(['key'=>'wait_tax']),get:'first');
        $after = $wallet->balance + $balance;
        $this->repo->save(new Request(['balance'=>$after]), $wallet->id);
        $this->transactionService->store(new Request(['wallet_id' =>$wallet->id, 'before' => $wallet->balance,
            'balance' => $balance, 'key' => 'add_tax_balance_wait_key', 'after' => $after,'advice_id'=>$data->id]));
    }

    public function addWaitPrice($data)
    {
        $balance = $data->price;
        $wallet= $this->repo->findBy(new Request(['key'=>'wait_balance']),get:'first');
        $after = $wallet->balance + $balance;
        $this->repo->save(new Request(['balance'=>$after]), $wallet->id);
        $this->transactionService->store(new Request(['wallet_id' =>$wallet->id, 'before' => $wallet->balance,
            'balance' => $balance, 'key' => 'add_balance_wait_key', 'after' => $after,'advice_id'=>$data->id]));
    }
}
