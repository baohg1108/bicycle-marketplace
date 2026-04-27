<?php

namespace Database\Seeders\Admin;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            [
                'id' => '1',
                'name' => 'KYC Management',
                'guard_name' => 'admin',
                'group_name' => 'KYC Management',
                'created_at' => '2026-04-25 06:06:26',
                'updated_at' => '2026-04-25 06:06:26',
            ],
            [
                'id' => '2',
                'name' => 'Role Managerment',
                'guard_name' => 'admin',
                'group_name' => 'Access Managemrnt',
                'created_at' => '2026-04-25 06:19:03',
                'updated_at' => '2026-04-25 06:19:03',
            ],
            [
                'id' => '3',
                'name' => 'Role User Manangement',
                'guard_name' => 'admin',
                'group_name' => 'Access Managemrnt',
                'created_at' => '2026-04-25 06:19:53',
                'updated_at' => '2026-04-25 06:19:53',
            ],
        ];
        DB::table('permissions')->insert($permissions);
    }
}