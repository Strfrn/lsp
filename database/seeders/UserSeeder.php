<?php

namespace Database\Seeders;

use Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123'),
            'role'=> 'admin',
        ]);

        DB::table('users')->insert([
            'name' => 'stefen',
            'email' => 'stefen@gmail.com',
            'password' => Hash::make('stefen123'),
            'role' => 'user',
        ]);
    }
}
