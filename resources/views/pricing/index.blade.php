<x-layouts.guest title="Pricing - ContentAI">
    <div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 dark:from-gray-900 dark:to-gray-800 py-12">
        <!-- Navigation -->
        <nav class="relative max-w-7xl mx-auto flex items-center justify-between px-4 sm:px-6 lg:px-8 mb-12">
            <div class="flex items-center space-x-2">
                <a href="{{ route('home') }}" class="flex items-center space-x-2">
                    <svg class="w-8 h-8 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2L2 7v10c0 5.55 3.84 9.95 9 11 5.16-1.05 9-5.45 9-11V7l-10-5z"/>
                    </svg>
                    <span class="text-2xl font-bold text-gray-900 dark:text-white">ContentAI</span>
                </a>
            </div>
            <div class="flex items-center space-x-4">
                @auth
                    <a href="{{ route('dashboard') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white font-medium">
                        Login
                    </a>
                    <a href="{{ route('register') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                        Get Started
                    </a>
                @endauth
            </div>
        </nav>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="text-center mb-16">
                <h1 class="text-4xl sm:text-5xl font-bold text-gray-900 dark:text-white mb-4">
                    💰 Simple, Transparent Pricing
                </h1>
                <p class="text-xl text-gray-600 dark:text-gray-300 max-w-3xl mx-auto">
                    Choose the perfect plan for your content creation needs. Upgrade, downgrade, or cancel anytime.
                </p>
            </div>

            <!-- Billing Toggle -->
            <div class="flex justify-center mb-12">
                <div class="bg-white dark:bg-gray-800 rounded-lg p-1 shadow-lg">
                    <div class="flex" x-data="{ billing: 'monthly' }">
                        <button @click="billing = 'monthly'"
                                :class="billing === 'monthly' ? 'bg-blue-600 text-white' : 'text-gray-700 dark:text-gray-300'"
                                class="px-6 py-2 rounded-md font-medium transition-colors">
                            Monthly
                        </button>
                        <button @click="billing = 'yearly'"
                                :class="billing === 'yearly' ? 'bg-blue-600 text-white' : 'text-gray-700 dark:text-gray-300'"
                                class="px-6 py-2 rounded-md font-medium transition-colors">
                            Yearly
                            <span class="ml-2 bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs font-semibold">
                                Save 20%
                            </span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Pricing Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-6xl mx-auto">
                @foreach($plans as $plan)
                    <div class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-xl {{ $plan['is_popular'] ? 'ring-2 ring-blue-600 scale-105' : '' }}">
                        @if($plan['is_popular'])
                            <div class="absolute -top-4 left-1/2 transform -translate-x-1/2">
                                <span class="bg-blue-600 text-white px-4 py-2 rounded-full text-sm font-semibold">
                                    🔥 Most Popular
                                </span>
                            </div>
                        @endif

                        <div class="p-8">
                            <!-- Plan Header -->
                            <div class="text-center mb-8">
                                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
                                    {{ $plan['name'] }}
                                </h3>
                                <p class="text-gray-600 dark:text-gray-300 mb-6">
                                    {{ $plan['description'] }}
                                </p>
                                
                                <!-- Price -->
                                <div class="mb-6" x-data="{ billing: 'monthly' }">
                                    <div x-show="billing === 'monthly'">
                                        <span class="text-4xl font-bold text-gray-900 dark:text-white">
                                            {{ $plan['formatted_monthly_price'] }}
                                        </span>
                                        <span class="text-gray-600 dark:text-gray-300">/month</span>
                                    </div>
                                    <div x-show="billing === 'yearly'">
                                        <span class="text-4xl font-bold text-gray-900 dark:text-white">
                                            {{ $plan['formatted_yearly_price'] }}
                                        </span>
                                        <span class="text-gray-600 dark:text-gray-300">/year</span>
                                        @if($plan['yearly_savings_percentage'] > 0)
                                            <div class="text-sm text-green-600 font-medium">
                                                Save {{ $plan['yearly_savings_percentage'] }}%
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                
                                <!-- Credits -->
                                <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-4 mb-6">
                                    <div class="text-2xl font-bold text-blue-600">
                                        {{ number_format($plan['credits_monthly']) }}
                                    </div>
                                    <div class="text-sm text-blue-700 dark:text-blue-300">
                                        Credits per month
                                    </div>
                                </div>
                            </div>

                            <!-- Features -->
                            <div class="space-y-4 mb-8">
                                @foreach($plan['features'] as $feature)
                                    <div class="flex items-start">
                                        <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        <span class="text-gray-700 dark:text-gray-300">{{ $feature }}</span>
                                    </div>
                                @endforeach
                                
                                @if($plan['max_team_members'])
                                    <div class="flex items-start">
                                        <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        <span class="text-gray-700 dark:text-gray-300">
                                            Up to {{ $plan['max_team_members'] }} team members
                                        </span>
                                    </div>
                                @endif
                            </div>

                            <!-- CTA Button -->
                            <div class="text-center">
                                @auth
                                    @if(auth()->user()->subscription_tier === $plan['slug'])
                                        <button class="w-full py-3 px-6 rounded-lg font-semibold text-gray-600 dark:text-gray-400 bg-gray-200 dark:bg-gray-700 cursor-not-allowed">
                                            Current Plan
                                        </button>
                                    @else
                                        <button class="w-full py-3 px-6 rounded-lg font-semibold text-white bg-blue-600 hover:bg-blue-700 transition-colors">
                                            {{ auth()->user()->subscription_tier === 'free' ? 'Upgrade to ' . $plan['name'] : 'Switch to ' . $plan['name'] }}
                                        </button>
                                    @endif
                                @else
                                    <a href="{{ route('register') }}" 
                                       class="w-full block py-3 px-6 rounded-lg font-semibold text-white bg-blue-600 hover:bg-blue-700 transition-colors text-center">
                                        Get Started with {{ $plan['name'] }}
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- FAQ Section -->
            <div class="mt-20 max-w-4xl mx-auto">
                <h2 class="text-3xl font-bold text-center text-gray-900 dark:text-white mb-12">
                    ❓ Frequently Asked Questions
                </h2>
                
                <div class="space-y-8">
                    <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-lg">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                            What happens if I run out of credits?
                        </h3>
                        <p class="text-gray-600 dark:text-gray-300">
                            If you run out of credits, you can upgrade your plan or purchase additional credits. Your account remains active, but you won't be able to generate new content until you have credits available.
                        </p>
                    </div>
                    
                    <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-lg">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                            Can I change my plan anytime?
                        </h3>
                        <p class="text-gray-600 dark:text-gray-300">
                            Yes! You can upgrade, downgrade, or cancel your subscription at any time. Changes take effect at the start of your next billing cycle.
                        </p>
                    </div>
                    
                    <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-lg">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                            Do unused credits roll over?
                        </h3>
                        <p class="text-gray-600 dark:text-gray-300">
                            No, credits reset each month with your billing cycle. We recommend using your credits within the month to get the most value from your subscription.
                        </p>
                    </div>
                    
                    <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-lg">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                            Is there a free trial?
                        </h3>
                        <p class="text-gray-600 dark:text-gray-300">
                            Yes! All new users start with our free plan that includes {{ $plans->firstWhere('slug', 'free')['credits_monthly'] ?? '10' }} credits to try our AI content generation features.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Contact Section -->
            <div class="mt-20 text-center">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
                    Need a Custom Plan?
                </h2>
                <p class="text-gray-600 dark:text-gray-300 mb-8">
                    Contact us for enterprise solutions and volume discounts
                </p>
                <a href="mailto:support@contentai.com" 
                   class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-gray-800 hover:bg-gray-900">
                    📧 Contact Sales
                </a>
            </div>
        </div>
    </div>
</x-layouts.guest>