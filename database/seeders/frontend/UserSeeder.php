<?php

namespace Database\Seeders\Frontend;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'Test user',
            'email' => 'user1@gmail.com',
            'password' => bcrypt('1234')
        ]);

        User::create([
            'name' => 'Vendor User',
            'email' => 'vendor@gmail.com',
            'password' => bcrypt('1234'),
            'user_type' => 'vendor'
        ]);
    }
}