<x-layouts.authenticated header="Generated Content">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <!-- Content Header -->
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                            {{ $content->title }}
                        </h1>
                        <div class="flex items-center mt-2 space-x-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-100">
                                {{ $content->contentType->name }}
                            </span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                {{ $content->status === 'completed' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-100' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-100' }}">
                                {{ ucfirst($content->status) }}
                            </span>
                            <span class="text-sm text-gray-500 dark:text-gray-400">
                                {{ $content->created_at->format('M j, Y \a\t g:i A') }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="flex space-x-2">
                        <a href="{{ route('content.index') }}" 
                           class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Back to Generator
                        </a>
                    </div>
                </div>

                @if($content->status === 'completed' && $content->generated_content)
                    <!-- Generated Content -->
                    <div class="space-y-6">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-3">
                                ✨ Generated Content
                            </h3>
                            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-6">
                                <div class="prose dark:prose-invert max-w-none">
                                    {!! nl2br(e($content->generated_content)) !!}
                                </div>
                            </div>
                        </div>

                        <!-- Copy to Clipboard Button -->
                        <div class="flex justify-center">
                            <button onclick="copyToClipboard()" 
                                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                </svg>
                                Copy Content
                            </button>
                        </div>
                    </div>
                @elseif($content->status === 'failed')
                    <!-- Error State -->
                    <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-6">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-red-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.502 0L4.309 15.5c-.77.833.192 2.5 1.732 2.5z"/>
                            </svg>
                            <h3 class="text-lg font-medium text-red-900 dark:text-red-100">
                                Content Generation Failed
                            </h3>
                        </div>
                        <p class="mt-2 text-red-700 dark:text-red-200">
                            Sorry, we couldn't generate your content. Please try again with different parameters.
                        </p>
                        <div class="mt-4">
                            <a href="{{ route('content.index') }}" 
                               class="inline-flex items-center px-4 py-2 border border-red-300 dark:border-red-600 rounded-md shadow-sm text-sm font-medium text-red-700 dark:text-red-200 bg-white dark:bg-red-900/20 hover:bg-red-50 dark:hover:bg-red-900/30">
                                Try Again
                            </a>
                        </div>
                    </div>
                @else
                    <!-- Processing State -->
                    <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-6">
                        <div class="flex items-center">
                            <div class="animate-spin rounded-full h-5 w-5 border-b-2 border-yellow-600 mr-3"></div>
                            <h3 class="text-lg font-medium text-yellow-900 dark:text-yellow-100">
                                Generating Content...
                            </h3>
                        </div>
                        <p class="mt-2 text-yellow-700 dark:text-yellow-200">
                            Your content is being generated. This usually takes a few seconds.
                        </p>
                    </div>
                @endif

                <!-- Input Parameters -->
                <div class="mt-8 border-t border-gray-200 dark:border-gray-700 pt-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">
                        📋 Generation Parameters
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Topic</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $content->input_data['topic'] ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tone</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ ucfirst($content->input_data['tone'] ?? 'N/A') }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Length</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ ucfirst($content->input_data['length'] ?? 'N/A') }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Credits Used</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $content->credits_used }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function copyToClipboard() {
            const content = `{{ addslashes($content->generated_content ?? '') }}`;
            navigator.clipboard.writeText(content).then(function() {
                // Show success message
                const button = event.target.closest('button');
                const originalText = button.innerHTML;
                button.innerHTML = `
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Copied!
                `;
                button.classList.remove('bg-blue-600', 'hover:bg-blue-700');
                button.classList.add('bg-green-600', 'hover:bg-green-700');
                
                setTimeout(() => {
                    button.innerHTML = originalText;
                    button.classList.remove('bg-green-600', 'hover:bg-green-700');
                    button.classList.add('bg-blue-600', 'hover:bg-blue-700');
                }, 2000);
            }).catch(function(err) {
                console.error('Could not copy text: ', err);
                alert('Failed to copy content');
            });
        }
    </script>
</x-layouts.authenticated>