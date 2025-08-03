<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateBrandVoiceRequest;
use Illuminate\Http\Request;


class ProfileController extends Controller
{
    /**
     * Display user profile page.
     */
    public function index()
    {
        $user = auth()->user();

        return view('profile.index', [
            'user' => $user,
            'subscription' => [
                'tier' => $user->subscription_tier,
                'expires_at' => $user->subscription_expires_at?->format('Y-m-d'),
                'is_active' => $user->hasActiveSubscription(),
            ],
        ]);
    }

    /**
     * Update brand voice.
     */
    public function updateBrandVoice(UpdateBrandVoiceRequest $request)
    {
        auth()->user()->update([
            'brand_voice' => $request->brand_voice,
        ]);

        return back()->with('success', 'Brand voice berhasil diperbarui.');
    }
}