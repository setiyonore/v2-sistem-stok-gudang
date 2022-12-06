<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //create user
        $user = User::query()->create([
            'name' => 'Administrator',
            'email' => 'admin@gmail.com',
            'password'=> bcrypt('password'),
        ]);
        //get all permission
        $permission = Permission::all();

        //get role admin
        $role = Role::find(1);

        //assign permission to role
        $role->syncPermission($permission);

        //assign role to user
        $user->assignRole($role);
    }
}
