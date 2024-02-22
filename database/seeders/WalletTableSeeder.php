<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Modules\Accounting\Entities\Wallet;
use Modules\Acl\Entities\Client;

class WalletTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $client = Client::where('wallet_id',0)->get();
        foreach($client as $c)
        {
            $c->update(['wallet_id'=>Wallet::create(['key'=>'wallet'])->id]);
        }
    }
}
