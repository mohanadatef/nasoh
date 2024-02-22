<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create(
            //admin default data
            [
                'id'=>1,
                'name' => 'admin',
                'email' => 'admin@admin.com',
                'password' => Hash::make('admin@admin.com'),
                'role_id' =>1,
                'status' => 1,
                'lang' => 'ar',
            ]);
    }
}
