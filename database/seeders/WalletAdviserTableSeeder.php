<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Modules\Accounting\Entities\Wallet;
use Modules\Acl\Entities\Adviser;
use Modules\Acl\Entities\Client;

class WalletAdviserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $advisers = Adviser::where('wallet_id',0)->get();
        foreach($advisers as $adviser)
        {
            $adviser->update(['wallet_id'=>Wallet::create(['key'=>'wallet'])->id]);
        }
    }
}
