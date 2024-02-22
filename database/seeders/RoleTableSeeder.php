<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Http\Request;
use Modules\Acl\Entities\Role;
use Modules\Acl\Service\RoleService;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'name' => 'admin',
                'status' => 1,
            ],
        ];
        foreach ($roles as $value) {
            $data = app()->make(RoleService::class)->findBy(new Request(['status' => $value['status']]), get: 'count');
            if ($data == 0) {
                $role = Role::create(['status' => 1]);
                foreach (language() as $lang) {
                    $role->translation()->create(['key' => 'name', 'value' => $value['name'], 'language_id' => $lang->id]);
                }
            }
        }
    }
}
