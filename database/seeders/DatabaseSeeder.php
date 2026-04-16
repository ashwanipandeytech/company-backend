<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Project;
use App\Models\ProjectType;
use App\Models\Enquiry;
use App\Models\Contact;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 0. Seed the Master Users/Roles first
        $this->call([
            AdminSeeder::class,
        ]);

        // 1. Create Dummy Clients
        $client1 = Client::create([
            'name' => 'TechNova Solutions',
            'website_url' => 'https://technova.example.com',
            'is_active' => true,
        ]);

        $client2 = Client::create([
            'name' => 'Alpha Logistics',
            'website_url' => 'https://alphalogistics.example.com',
            'is_active' => true,
        ]);

        // 2. Create Dummy Projects linked to Clients
        Project::create([
            'client_id' => $client1->id,
            'title' => 'E-Commerce Revamp',
            'slug' => 'e-commerce-revamp',
            'description' => 'A complete overhaul of the TechNova e-commerce platform.',
            'status' => 'completed',
        ]);

        Project::create([
            'client_id' => $client2->id,
            'title' => 'Logistics Tracking App',
            'slug' => 'logistics-tracking-app',
            'description' => 'Real-time GPS tracking application for Alpha fleet.',
            'status' => 'ongoing',
        ]);

        // 3. Create Database-Driven Project Types
        $type1 = ProjectType::create(['name' => 'Web Development']);
        $type2 = ProjectType::create(['name' => 'Mobile App Development']);
        $type3 = ProjectType::create(['name' => 'UI/UX Design']);

        // 4. Create Dummy Contact & Enquiry to verify Admin Panel later
        Contact::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'subject' => 'Partnership Opportunity',
            'message' => 'We would love to partner with your IT firm.',
        ]);

        Enquiry::create([
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
            'phone' => '+1234567890',
            'company_name' => 'Smith Enterprises',
            'project_type_id' => $type1->id,
            'budget_estimation' => '$5k - $10k',
            'estimated_timeline' => '1-3 months',
            'requirements' => 'We need a robust corporate website with a CMS.',
        ]);
    }
}