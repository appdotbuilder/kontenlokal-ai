<x-layouts.authenticated header="Profile">
    <div class="space-y-6">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Profile Information -->
            <div class="lg:col-span-2 space-y-6">
                <!-- User Info -->
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white mb-4">
                            👤 Profile Information
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Name</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $user->name }}</p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $user->email }}</p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Member Since</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $user->created_at->format('M j, Y') }}</p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Account Status</label>
                                <span class="mt-1 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $user->is_active ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-100' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-100' }}">
                                    {{ $user->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Brand Voice -->
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white mb-4">
                            🎯 Brand Voice & Tone
                        </h3>
                        
                        <form method="POST" action="{{ route('profile.brand-voice.update') }}">
                            @csrf
                            @method('PUT')
                            
                            <div class="mb-4">
                                <label for="brand_voice" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Describe your brand voice and tone
                                </label>
                                <textarea name="brand_voice" 
                                          id="brand_voice" 
                                          rows="4"
                                          class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                          placeholder="e.g., Professional but approachable, casual and friendly, formal and authoritative..."
                                >{{ old('brand_voice', $user->brand_voice) }}</textarea>
                                @error('brand_voice')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4 mb-4">
                                <div class="flex">
                                    <svg class="w-5 h-5 text-blue-600 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <div>
                                        <h4 class="text-sm font-medium text-blue-900 dark:text-blue-100">How this helps</h4>
                                        <p class="mt-1 text-sm text-blue-700 dark:text-blue-200">
                                            AI will use this information to generate content that matches your brand's personality and communication style.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            
                            <button type="submit" 
                                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Update Brand Voice
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white mb-4">
                            📈 Recent Activity
                        </h3>
                        
                        @php
                            $recentContents = $user->generatedContents()->with('contentType')->latest()->take(5)->get();
                        @endphp
                        
                        @if($recentContents->count() > 0)
                            <div class="space-y-3">
                                @foreach($recentContents as $content)
                                    <div class="flex items-center justify-between py-2 border-b border-gray-200 dark:border-gray-700 last:border-b-0">
                                        <div class="flex-1">
                                            <h4 class="text-sm font-medium text-gray-900 dark:text-white">
                                                {{ $content->title }}
                                            </h4>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                                {{ $content->contentType->name }} • {{ $content->created_at->diffForHumans() }}
                                            </p>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                                {{ $content->status === 'completed' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-100' : 
                                                   ($content->status === 'failed' ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-100' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-100') }}">
                                                {{ ucfirst($content->status) }}
                                            </span>
                                            <a href="{{ route('content.show', $content) }}" 
                                               class="text-blue-600 hover:text-blue-500 text-xs font-medium">
                                                View
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            
                            <div class="mt-4">
                                <a href="{{ route('content.history') }}" 
                                   class="text-sm text-blue-600 hover:text-blue-500 font-medium">
                                    View all content →
                                </a>
                            </div>
                        @else
                            <p class="text-gray-500 dark:text-gray-400 text-sm">
                                No content generated yet. <a href="{{ route('content.index') }}" class="text-blue-600 hover:text-blue-500">Create your first content</a>
                            </p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Credits & Subscription -->
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white mb-4">
                            💳 Credits & Subscription
                        </h3>
                        
                        <!-- Credits -->
                        <div class="mb-4">
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Available Credits</span>
                                <span class="text-2xl font-bold text-blue-600">{{ $user->credits }}</span>
                            </div>
                            
                            <div class="mt-2 w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                @php
                                    $maxCredits = 100; // Assuming max credits for visualization
                                    $percentage = min(($user->credits / $maxCredits) * 100, 100);
                                @endphp
                                <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                            </div>
                        </div>
                        
                        <!-- Subscription -->
                        <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Subscription</span>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-100">
                                    {{ ucfirst($subscription['tier']) }}
                                </span>
                            </div>
                            
                            @if($subscription['tier'] !== 'free' && $subscription['expires_at'])
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ $subscription['is_active'] ? 'Expires' : 'Expired' }} on {{ \Carbon\Carbon::parse($subscription['expires_at'])->format('M j, Y') }}
                                </p>
                            @endif
                            
                            <div class="mt-4">
                                <a href="{{ route('pricing') }}" 
                                   class="w-full text-center block px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                                    {{ $subscription['tier'] === 'free' ? 'Upgrade Plan' : 'Manage Subscription' }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Usage Statistics -->
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white mb-4">
                            📊 Usage Statistics
                        </h3>
                        
                        @php
                            $totalContent = $user->generatedContents()->count();
                            $completedContent = $user->generatedContents()->where('status', 'completed')->count();
                            $totalCreditsUsed = $user->generatedContents()->sum('credits_used');
                        @endphp
                        
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-700 dark:text-gray-300">Total Content</span>
                                <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $totalContent }}</span>
                            </div>
                            
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-700 dark:text-gray-300">Completed</span>
                                <span class="text-sm font-semibold text-green-600">{{ $completedContent }}</span>
                            </div>
                            
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-700 dark:text-gray-300">Credits Used</span>
                                <span class="text-sm font-semibold text-blue-600">{{ $totalCreditsUsed }}</span>
                            </div>
                            
                            @if($totalContent > 0)
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-700 dark:text-gray-300">Success Rate</span>
                                    <span class="text-sm font-semibold text-gray-900 dark:text-white">
                                        {{ round(($completedContent / $totalContent) * 100, 1) }}%
                                    </span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white mb-4">
                            ⚡ Quick Actions
                        </h3>
                        
                        <div class="space-y-3">
                            <a href="{{ route('content.index') }}" 
                               class="w-full flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                                Create Content
                            </a>
                            
                            <a href="{{ route('content.history') }}" 
                               class="w-full flex items-center justify-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                View History
                            </a>
                            
                            <a href="{{ route('calendar.index') }}" 
                               class="w-full flex items-center justify-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                Content Calendar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.authenticated>