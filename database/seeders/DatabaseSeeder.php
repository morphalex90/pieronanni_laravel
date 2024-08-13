<?php

namespace Database\Seeders;

use App\Models\Contact;
use App\Models\Job;
use App\Models\Technology;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
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

        Technology::create(['key' => '*', 'name' => 'All',]);
        Technology::create(['key' => 'drupal', 'name' => 'Drupal',]);
        Technology::create(['key' => 'html', 'name' => 'HTML',]);
        Technology::create(['key' => 'magento', 'name' => 'Magento',]);
        Technology::create(['key' => 'laravel', 'name' => 'Laravel',]);
        Technology::create(['key' => 'react', 'name' => 'React',]);
        Technology::create(['key' => 'nextjs', 'name' => 'Next.js',]);
        Technology::create(['key' => 'wp', 'name' => 'WordPress',]);

        Contact::factory(10)->create();
        Job::factory(10)->create();
    }
}
