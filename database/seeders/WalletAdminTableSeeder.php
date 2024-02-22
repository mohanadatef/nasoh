<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Modules\Accounting\Entities\Wallet;
use Modules\Acl\Entities\Client;

class WalletAdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         Wallet::create(['key'=>'admin_tax']);
         Wallet::create(['key'=>'wait_tax']);
        Wallet::create(['key'=>'wait_balance']);
        Wallet::create(['key'=>'admin_balance']);

    }
}
