<?php

namespace Database\Seeders\Admin;
use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void{

    // create super admin
        $admin = new Admin();
        $admin->name = 'SUPER ADMIN';
        $admin->email = 'admin@gmail.com';
        $admin->password = bcrypt('1234');
        $admin->save();

    // create super admin role
    Role::create(['name' => 'Super Admin', 'guard' => 'admin']);

    // assign super admin role to super admin
    $admin->assignRole('Super Admin');
    
    }
}