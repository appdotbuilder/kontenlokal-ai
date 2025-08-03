<?php

namespace Database\Seeders;

use App\Models\SubscriptionPlan;
use Illuminate\Database\Seeder;

class SubscriptionPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plans = [
            [
                'name' => 'Free',
                'slug' => 'free',
                'description' => 'Sempurna untuk mencoba KontenLokal AI',
                'price_monthly' => 0,
                'price_yearly' => 0,
                'credits_monthly' => 20,
                'features' => [
                    '20 kredit konten per bulan',
                    'Akses ke semua jenis konten',
                    'Brand voice personal',
                    'Kalender ide konten',
                    'Support email'
                ],
                'max_team_members' => 1,
                'is_popular' => false,
                'is_active' => true,
                'sort_order' => 1
            ],
            [
                'name' => 'Basic',
                'slug' => 'basic',
                'description' => 'Ideal untuk UKM yang baru memulai digital marketing',
                'price_monthly' => 99000,
                'price_yearly' => 990000, // 2 months free
                'credits_monthly' => 100,
                'features' => [
                    '100 kredit konten per bulan',
                    'Akses ke semua jenis konten',
                    'Brand voice personal',
                    'Kalender ide konten',
                    'Priority support',
                    'Export ke berbagai format',
                    'Riwayat konten 6 bulan'
                ],
                'max_team_members' => 2,
                'is_popular' => false,
                'is_active' => true,
                'sort_order' => 2
            ],
            [
                'name' => 'Pro',
                'slug' => 'pro',
                'description' => 'Terbaik untuk bisnis yang serius dengan content marketing',
                'price_monthly' => 199000,
                'price_yearly' => 1990000, // 2 months free
                'credits_monthly' => 300,
                'features' => [
                    '300 kredit konten per bulan',
                    'Akses ke semua jenis konten',
                    'Multiple brand voice',
                    'Kalender ide konten',
                    'Priority support 24/7',
                    'Export ke berbagai format',
                    'Riwayat konten unlimited',
                    'Analytics & reporting',
                    'API access',
                    'Bulk content generation'
                ],
                'max_team_members' => 5,
                'is_popular' => true,
                'is_active' => true,
                'sort_order' => 3
            ],
            [
                'name' => 'Enterprise',
                'slug' => 'enterprise',
                'description' => 'Solusi lengkap untuk perusahaan besar',
                'price_monthly' => 499000,
                'price_yearly' => 4990000, // 2 months free
                'credits_monthly' => 1000,
                'features' => [
                    '1000 kredit konten per bulan',
                    'Akses ke semua jenis konten',
                    'Unlimited brand voice',
                    'Kalender ide konten',
                    'Dedicated account manager',
                    'Export ke berbagai format',
                    'Riwayat konten unlimited',
                    'Advanced analytics & reporting',
                    'Full API access',
                    'Bulk content generation',
                    'Custom integrations',
                    'White-label options',
                    'Training & onboarding'
                ],
                'max_team_members' => 20,
                'is_popular' => false,
                'is_active' => true,
                'sort_order' => 4
            ]
        ];

        foreach ($plans as $plan) {
            SubscriptionPlan::create($plan);
        }
    }
}