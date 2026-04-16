<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Super Admin (System Owner - highest privilege)
        User::updateOrCreate(
            ['email' => env('ADMIN_DEFAULT_EMAIL', 'superadmin@example.com')],
            [
                'name' => 'System Superadmin',
                'password' => Hash::make(env('ADMIN_DEFAULT_PASSWORD', 'secret123')),
                'role' => 'superadmin',
            ]
        );

        // 2. General Admin (System Operations)
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'General Admin',
                'password' => Hash::make('secret123'),
                'role' => 'admin',
            ]
        );

        // 3. Sales Manager (To handle incoming Enquiries and Contacts)
        User::updateOrCreate(
            ['email' => 'sales@example.com'],
            [
                'name' => 'Sales Manager',
                'password' => Hash::make('secret123'),
                'role' => 'manager',
            ]
        );

        // 4. Content Editor (To manage the Portfolio: Projects and Clients)
        User::updateOrCreate(
            ['email' => 'editor@example.com'],
            [
                'name' => 'Content Editor',
                'password' => Hash::make('secret123'),
                'role' => 'editor',
            ]
        );
    }
}