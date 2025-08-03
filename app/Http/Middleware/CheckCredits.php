<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckCredits
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, int $requiredCredits = 1): Response
    {
        $user = auth()->user();

        if (!$user) {
            return redirect()->route('login');
        }

        if (!$user->hasCredits($requiredCredits)) {
            return redirect()->route('pricing')
                ->withErrors([
                    'credits' => 'Kredit Anda tidak mencukupi. Silakan upgrade paket untuk melanjutkan.'
                ]);
        }

        return $next($request);
    }
}