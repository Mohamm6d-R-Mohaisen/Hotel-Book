<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // make admin pages permissions
        $admin_parents = [
            'admins' => ['view', 'add', 'edit', 'delete'],
            'users' => ['view', 'add', 'edit', 'delete'],

            'roles' => ['view', 'add', 'edit', 'delete'],
            'home' => ['view'],
            'settings' => ['view', 'add', 'edit', 'delete'],
        ];
        foreach ($admin_parents as $parent => $types) {
            foreach ($types as $type) {
                Permission::create(['name_key' => $type, 'guard_name'=>'admin', 'name' => "$type" . "_" . $parent, 'parent' => $parent]);
            }
        }
    }
}
