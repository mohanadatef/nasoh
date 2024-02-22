<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Http\Request;
use Modules\Acl\Entities\Permission;
use Modules\Acl\Entities\Role;
use Modules\Acl\Service\PermissionService;

class PermissionDeleteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $permission = app()->make(PermissionService::class)->findBy(new Request(['name' => 'adviser-create']),get:'first');
       if($permission)
       {
           $permission->delete();
       }
    }
}
