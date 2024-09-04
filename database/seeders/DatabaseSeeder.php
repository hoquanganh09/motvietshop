<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Role::create([
            'id' => Role::ROOT,
            'level' => 0,
            'name' => 'ROOT',
        ]);

        Role::create([
            'id' => Role::SUPER_ADMIN,
            'level' => 1,
            'name' => 'Super Admin',
        ]);

        Role::create([
            'id' => Role::ADMIN,
            'level' => 2,
            'name' => 'Admin',
        ]);

        Role::create([
            'id' => Role::USER,
            'level' => 3,
            'name' => 'User',
        ]);

        User::create([
            'fullname' => 'Ho Quang Anh',
            'role' => Role::ROOT,
            'email' => 'root@admin.com',
            'password' => Hash::make('admin123'),
            'is_admin' => true,
        ]);

        User::create([
            'fullname' => 'Ho Quang Anh',
            'role' => Role::SUPER_ADMIN,
            'email' => 'superadmin@admin.com',
            'password' => Hash::make('admin123'),
        ]);

        User::create([
            'fullname' => 'Ho Quang Anh',
            'role' => Role::ADMIN,
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin123'),
        ]);

        User::create([
            'fullname' => 'Ho Quang Anh',
            'role' => Role::USER,
            'email' => 'user@admin.com',
            'password' => Hash::make('admin123'),
        ]);
    }
}
