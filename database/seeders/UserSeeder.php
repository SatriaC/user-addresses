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

        Permission::create(['name' => 'approve delete']);
        $roleAdmin = Role::create(["name" => "admin"]);
        $roleAdmin->givePermissionTo('approve-delete');

        $admin->assignRole($roleAdmin);
    }
}
