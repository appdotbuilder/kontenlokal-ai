<?php

namespace Database\Seeders;

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
        // Seed core data
        $this->call([
            ContentTypeSeeder::class,
            SubscriptionPlanSeeder::class,
            ContentCalendarSeeder::class,
        ]);

        // Create test user
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'credits' => 50,
            'brand_voice' => 'Ramah, profesional, dan menggunakan bahasa yang mudah dipahami. Fokus pada nilai kualitas dan kepercayaan pelanggan.',
        ]);
    }
}
