<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionPlan;


class PricingController extends Controller
{
    /**
     * Display the pricing page.
     */
    public function index()
    {
        $plans = SubscriptionPlan::active()
            ->orderBy('sort_order')
            ->get()
            ->map(function ($plan) {
                return [
                    'id' => $plan->id,
                    'name' => $plan->name,
                    'slug' => $plan->slug,
                    'description' => $plan->description,
                    'price_monthly' => $plan->price_monthly,
                    'price_yearly' => $plan->price_yearly,
                    'credits_monthly' => $plan->credits_monthly,
                    'features' => $plan->features,
                    'max_team_members' => $plan->max_team_members,
                    'is_popular' => $plan->is_popular,
                    'formatted_monthly_price' => $plan->getFormattedMonthlyPriceAttribute(),
                    'formatted_yearly_price' => $plan->getFormattedYearlyPriceAttribute(),
                    'yearly_savings_percentage' => $plan->getYearlySavingsPercentageAttribute(),
                ];
            });

        return view('pricing.index', [
            'plans' => $plans,
        ]);
    }
}