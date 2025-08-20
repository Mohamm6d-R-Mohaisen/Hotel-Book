<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $admin = Admin::create([
            'name'=>'Super Admin',
            'email'=>'admin@gmail.com',
            'password' => bcrypt('123456789')


        ]);
        // assign permissions to admin role
        $admin_role = Role::where('name', 'admin')->where('guard_name', 'admin')->first();
        if ($admin_role) {
            $permissions = Permission::where('guard_name', 'admin')->pluck('id','id');
            $admin_role->syncPermissions($permissions);

            // assign role to the admin admin
            $admin->assignRole([$admin_role->id]);
        }
    }
}
