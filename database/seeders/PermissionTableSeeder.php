<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Http\Request;
use Modules\Acl\Entities\Permission;
use Modules\Acl\Entities\Role;
use Modules\Acl\Service\PermissionService;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $models = modelPermission();
        $names =
            [
                ['label' => "show", 'name' => 'show'],
                ['label' => "create", 'name' => 'create'],
                ['label' => "edit", 'name' => 'edit'],
                ['label' => "delete", 'name' => 'delete'],
                ['label' => "status", 'name' => 'status'],
            ];
        foreach ($models as $model) {
            foreach ($names as $name) {
                $newName =  $model . '-' . $name['name'];
                if(app()->make(PermissionService::class)->findBy(new Request(['name' => $newName]), get:'count') == 0)
                {
                    $permission = Permission::create(['name' => $newName]);
                    foreach (language() as $lang) {
                        $permission->translation()->create(['key' => 'display_name', 'value' => $newName, 'language_id' => $lang->id]);
                    }
                }
            }
        }
        Role::find(1)->permission()->sync(app()->make(PermissionService::class)->findBy(new Request())->pluck('id')->toArray());
    }
}
