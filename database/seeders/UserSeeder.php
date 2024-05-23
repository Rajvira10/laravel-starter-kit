<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = new User();
        $user->username = 'admin';
        $user->email = 'admin@gmail.com';
        $user->password = Hash::make('12345678');
        $user->status = 'active';
        $user->save();

        $role = new Role();
        $role->name = 'Super Admin';
        $role->display_name = 'Super Admin';
        $role->description = 'Super Admin';
        $role->status = 'active';
        $role->save();

        $user->role_id = $role->id;
        $user->save();        
    }
}
