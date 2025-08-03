<x-layouts.authenticated header="Generate Content">
    <div class="space-y-6">
        <!-- User Credits Display -->
        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                </svg>
                <span class="font-medium text-blue-900 dark:text-blue-100">Available Credits: {{ $userCredits }}</span>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Content Generator Form -->
            <div class="lg:col-span-2">
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white mb-4">
                            ✨ Create New Content
                        </h3>

                        <form method="POST" action="{{ route('content.store') }}" class="space-y-6">
                            @csrf
                            
                            <!-- Title -->
                            <div>
                                <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Content Title
                                </label>
                                <input type="text" 
                                       name="title" 
                                       id="title" 
                                       value="{{ old('title') }}"
                                       class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                       placeholder="Enter a descriptive title for your content">
                                @error('title')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Content Type -->
                            <div>
                                <label for="content_type_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Content Type
                                </label>
                                <select name="content_type_id" 
                                        id="content_type_id" 
                                        class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                        onchange="updateCreditCost(this)">
                                    <option value="">Select content type</option>
                                    @foreach($contentTypes as $contentType)
                                        <option value="{{ $contentType->id }}" 
                                                data-cost="{{ $contentType->credit_cost }}"
                                                {{ old('content_type_id') == $contentType->id ? 'selected' : '' }}>
                                            {{ $contentType->name }} ({{ $contentType->credit_cost }} credits)
                                        </option>
                                    @endforeach
                                </select>
                                @error('content_type_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Topic -->
                            <div>
                                <label for="topic" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Topic/Subject
                                </label>
                                <textarea name="input_data[topic]" 
                                          id="topic" 
                                          rows="3"
                                          class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                          placeholder="Describe what you want the content to be about...">{{ old('input_data.topic') }}</textarea>
                                @error('input_data.topic')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Tone -->
                            <div>
                                <label for="tone" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Tone
                                </label>
                                <select name="input_data[tone]" 
                                        id="tone" 
                                        class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                    <option value="professional" {{ old('input_data.tone') == 'professional' ? 'selected' : '' }}>Professional</option>
                                    <option value="casual" {{ old('input_data.tone') == 'casual' ? 'selected' : '' }}>Casual</option>
                                    <option value="friendly" {{ old('input_data.tone') == 'friendly' ? 'selected' : '' }}>Friendly</option>
                                    <option value="formal" {{ old('input_data.tone') == 'formal' ? 'selected' : '' }}>Formal</option>
                                    <option value="creative" {{ old('input_data.tone') == 'creative' ? 'selected' : '' }}>Creative</option>
                                </select>
                            </div>

                            <!-- Length -->
                            <div>
                                <label for="length" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Content Length
                                </label>
                                <select name="input_data[length]" 
                                        id="length" 
                                        class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                    <option value="short" {{ old('input_data.length') == 'short' ? 'selected' : '' }}>Short</option>
                                    <option value="medium" {{ old('input_data.length') == 'medium' ? 'selected' : '' }}>Medium</option>
                                    <option value="long" {{ old('input_data.length') == 'long' ? 'selected' : '' }}>Long</option>
                                </select>
                            </div>

                            <!-- Brand Voice (if user has one) -->
                            @if(auth()->user()->brand_voice)
                                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                    <h4 class="font-medium text-gray-900 dark:text-white mb-2">Brand Voice</h4>
                                    <p class="text-sm text-gray-600 dark:text-gray-300">{{ auth()->user()->brand_voice }}</p>
                                </div>
                            @endif

                            <!-- Credit Cost Display -->
                            <div id="credit-cost" class="hidden bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-3">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 text-yellow-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.502 0L4.309 15.5c-.77.833.192 2.5 1.732 2.5z"/>
                                    </svg>
                                    <span class="text-sm font-medium text-yellow-800 dark:text-yellow-200">
                                        This will cost <span id="cost-amount">0</span> credits
                                    </span>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div>
                                <button type="submit" 
                                        class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50 disabled:cursor-not-allowed">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                    </svg>
                                    Generate Content
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Recent Content Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white mb-4">
                            📝 Recent Content
                        </h3>
                        
                        @if($recentContents->count() > 0)
                            <div class="space-y-3">
                                @foreach($recentContents as $content)
                                    <div class="border border-gray-200 dark:border-gray-600 rounded-lg p-3">
                                        <h4 class="font-medium text-gray-900 dark:text-white text-sm">
                                            {{ $content['title'] }}
                                        </h4>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                            {{ $content['content_type']['name'] }}
                                        </p>
                                        <div class="flex items-center justify-between mt-2">
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                                {{ $content['status'] === 'completed' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-100' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-100' }}">
                                                {{ ucfirst($content['status']) }}
                                            </span>
                                            <a href="{{ route('content.show', $content['id']) }}" 
                                               class="text-blue-600 hover:text-blue-500 text-xs">
                                                View
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            
                            <div class="mt-4">
                                <a href="{{ route('content.history') }}" 
                                   class="w-full text-center block px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700">
                                    View All Content
                                </a>
                            </div>
                        @else
                            <p class="text-gray-500 dark:text-gray-400 text-sm">
                                No content generated yet. Create your first piece of content!
                            </p>
                        @endif
                    </div>
                </div>

                <!-- Content Types Info -->
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg mt-6">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white mb-4">
                            🎯 Available Content Types
                        </h3>
                        
                        <div class="space-y-2">
                            @foreach($contentTypes as $contentType)
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-gray-700 dark:text-gray-300">{{ $contentType->name }}</span>
                                    <span class="text-blue-600 dark:text-blue-400 font-medium">{{ $contentType->credit_cost }} credits</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function updateCreditCost(select) {
            const costDisplay = document.getElementById('credit-cost');
            const costAmount = document.getElementById('cost-amount');
            
            if (select.value) {
                const selectedOption = select.options[select.selectedIndex];
                const cost = selectedOption.dataset.cost;
                costAmount.textContent = cost;
                costDisplay.classList.remove('hidden');
            } else {
                costDisplay.classList.add('hidden');
            }
        }
    </script>
</x-layouts.authenticated>