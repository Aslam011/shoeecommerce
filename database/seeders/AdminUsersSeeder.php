<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
       DB::table('users')->updateOrInsert(
    ['email' => 'admin@gmail.com'], // match your login email
    [
        'name' => 'Shop Admin',
        'password' => Hash::make('arsalan117'), // the password you want
        'is_admin' => 1,
        'role' => 'admin',
        'created_at' => now(),
        'updated_at' => now(),
    ]
);

    }
}
