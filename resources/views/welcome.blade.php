<x-layouts.guest title="ContentAI - AI-Powered Content Generation">
    <div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 dark:from-gray-900 dark:to-gray-800">
        <!-- Navigation -->
        <nav class="relative max-w-7xl mx-auto flex items-center justify-between px-4 sm:px-6 lg:px-8 pt-6">
            <div class="flex items-center space-x-2">
                <svg class="w-8 h-8 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2L2 7v10c0 5.55 3.84 9.95 9 11 5.16-1.05 9-5.45 9-11V7l-10-5z"/>
                </svg>
                <span class="text-2xl font-bold text-gray-900 dark:text-white">ContentAI</span>
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

        <!-- Hero Section -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-20 pb-16">
            <div class="text-center">
                <h1 class="text-4xl sm:text-6xl font-bold text-gray-900 dark:text-white mb-6">
                    🚀 AI-Powered Content Generation
                </h1>
                <p class="text-xl text-gray-600 dark:text-gray-300 mb-8 max-w-3xl mx-auto">
                    Create engaging content for social media, blogs, and marketing campaigns in seconds. 
                    Let AI transform your ideas into compelling copy that converts.
                </p>
                
                <!-- CTA Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center mb-12">
                    @auth
                        <a href="{{ route('dashboard') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-lg text-lg font-semibold transition-colors inline-flex items-center justify-center">
                            Go to Dashboard
                            <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-lg text-lg font-semibold transition-colors inline-flex items-center justify-center">
                            Start Creating Free
                            <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                        <a href="{{ route('pricing') }}" class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-900 dark:text-white px-8 py-4 rounded-lg text-lg font-semibold border border-gray-300 dark:border-gray-600 transition-colors">
                            View Pricing
                        </a>
                    @endauth
                </div>

                <!-- Features Grid -->
                <div class="grid md:grid-cols-3 gap-8 max-w-5xl mx-auto">
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg">
                        <div class="text-4xl mb-4">✨</div>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">AI Content Generation</h3>
                        <p class="text-gray-600 dark:text-gray-300">Generate high-quality blog posts, social media content, and marketing copy with advanced AI technology.</p>
                    </div>
                    
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg">
                        <div class="text-4xl mb-4">📅</div>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Content Calendar</h3>
                        <p class="text-gray-600 dark:text-gray-300">Plan and schedule your content with our intuitive calendar interface. Never miss a posting opportunity.</p>
                    </div>
                    
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg">
                        <div class="text-4xl mb-4">🎯</div>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Brand Voice Consistency</h3>
                        <p class="text-gray-600 dark:text-gray-300">Maintain your unique brand voice across all content with customizable tone and style settings.</p>
                    </div>
                    
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg">
                        <div class="text-4xl mb-4">⚡</div>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Lightning Fast</h3>
                        <p class="text-gray-600 dark:text-gray-300">Generate content in seconds, not hours. Boost your productivity and meet tight deadlines effortlessly.</p>
                    </div>
                    
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg">
                        <div class="text-4xl mb-4">💎</div>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Multiple Content Types</h3>
                        <p class="text-gray-600 dark:text-gray-300">From social posts to email campaigns, create diverse content formats tailored to your needs.</p>
                    </div>
                    
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg">
                        <div class="text-4xl mb-4">📊</div>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Content Analytics</h3>
                        <p class="text-gray-600 dark:text-gray-300">Track your content performance and optimize your strategy with detailed analytics and insights.</p>
                    </div>
                </div>

                <!-- Demo Preview -->
                <div class="mt-16">
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-8">See ContentAI in Action</h2>
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl p-8 max-w-4xl mx-auto">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Content Generator</h3>
                            <span class="bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-100 px-3 py-1 rounded-full text-sm font-medium">Live Demo</span>
                        </div>
                        
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6 mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Content Type:</label>
                            <div class="bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-100 px-3 py-1 rounded-md inline-block">
                                📱 Social Media Post
                            </div>
                        </div>
                        
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6 mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Topic:</label>
                            <p class="text-gray-900 dark:text-white">"Benefits of morning meditation"</p>
                        </div>
                        
                        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-lg p-6 border-l-4 border-blue-500">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Generated Content:</label>
                            <p class="text-gray-900 dark:text-white font-medium">
                                "🌅 Start your day with intention! Just 10 minutes of morning meditation can transform your entire day. Experience better focus, reduced stress, and inner peace. 
                                <span class="text-blue-600">#MorningMeditation #Mindfulness #WellnessJourney</span>"
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Footer CTA -->
                <div class="mt-20 text-center">
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">
                        Ready to Transform Your Content Strategy?
                    </h2>
                    <p class="text-xl text-gray-600 dark:text-gray-300 mb-8">
                        Join thousands of content creators who are already using ContentAI
                    </p>
                    @guest
                        <a href="{{ route('register') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-12 py-4 rounded-lg text-xl font-bold transition-colors inline-flex items-center justify-center">
                            Get Started Free Today
                            <svg class="ml-3 w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                        </a>
                    @endguest
                </div>
            </div>
        </div>
    </div>
</x-layouts.guest>