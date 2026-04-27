<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
use Database\Seeders\Admin\AdminSeeder;
use Database\Seeders\Admin\PermissionSeeder;
use Database\Seeders\Frontend\UserSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // admin seeders
        $this->call(AdminSeeder::class);
        $this->call(PermissionSeeder::class);

        // frontend seeder
        $this->call(UserSeeder::class);
    }
}