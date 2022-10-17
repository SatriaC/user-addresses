<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@test.com',
            'password' => bcrypt('1234567890'),
        ]);

        $user = User::create([
            'name' => 'John Doe',
            'email' => 'john@test.com',
            'password' => bcrypt('1234567890'),
        ]);

        Permission::create(['name' => 'address-approval']);
        Permission::create(['name' => 'user-nearest']);
        Permission::create(['name' => 'user-add']);
        Permission::create(['name' => 'user-update']);
        Permission::create(['name' => 'user-delete']);

        $role1 = Role::create(['name' => 'admin']);
        $role1->givePermissionTo('address-approval');
        $role1->givePermissionTo('user-nearest');
        $role1->givePermissionTo('user-add');
        $role1->givePermissionTo('user-update');
        $role1->givePermissionTo('user-delete');

        $admin->assignRole($role1);
    }
}
