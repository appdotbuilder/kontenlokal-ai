<x-layouts.authenticated header="Content Calendar">
    <div class="space-y-6">
        <!-- Calendar Navigation -->
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
                        📅 {{ DateTime::createFromFormat('!m', $currentMonth)->format('F') }} {{ $currentYear }}
                    </h2>
                    <div class="flex space-x-2">
                        <a href="{{ route('calendar.index', ['month' => $currentMonth > 1 ? $currentMonth - 1 : 12, 'year' => $currentMonth > 1 ? $currentYear : $currentYear - 1]) }}" 
                           class="inline-flex items-center px-3 py-2 border border-gray-300 dark:border-gray-600 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                            Previous
                        </a>
                        <a href="{{ route('calendar.index', ['month' => now()->month, 'year' => now()->year]) }}" 
                           class="inline-flex items-center px-3 py-2 border border-gray-300 dark:border-gray-600 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700">
                            Today
                        </a>
                        <a href="{{ route('calendar.index', ['month' => $currentMonth < 12 ? $currentMonth + 1 : 1, 'year' => $currentMonth < 12 ? $currentYear : $currentYear + 1]) }}" 
                           class="inline-flex items-center px-3 py-2 border border-gray-300 dark:border-gray-600 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700">
                            Next
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Calendar Grid -->
            <div class="lg:col-span-2">
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
                    <!-- Calendar Header -->
                    <div class="grid grid-cols-7 gap-px bg-gray-200 dark:bg-gray-600">
                        @foreach(['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $day)
                            <div class="bg-gray-50 dark:bg-gray-700 py-2 text-center">
                                <span class="text-xs font-semibold text-gray-900 dark:text-white uppercase tracking-wide">{{ $day }}</span>
                            </div>
                        @endforeach
                    </div>

                    <!-- Calendar Body -->
                    <div class="grid grid-cols-7 gap-px bg-gray-200 dark:bg-gray-600">
                        @php
                            $firstDay = \Carbon\Carbon::createFromDate($currentYear, $currentMonth, 1);
                            $lastDay = $firstDay->copy()->endOfMonth();
                            $startCalendar = $firstDay->copy()->startOfWeek();
                            $endCalendar = $lastDay->copy()->endOfWeek();
                            $currentDate = $startCalendar->copy();
                        @endphp

                        @while($currentDate <= $endCalendar)
                            @php
                                $dayEvents = $events->filter(function ($event) use ($currentDate) {
                                    return $event['event_date'] === $currentDate->toDateString();
                                });
                                $isCurrentMonth = $currentDate->month == $currentMonth;
                                $isToday = $currentDate->isToday();
                            @endphp

                            <div class="bg-white dark:bg-gray-800 min-h-[120px] p-2 {{ $isCurrentMonth ? '' : 'text-gray-400 dark:text-gray-600' }}">
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-sm font-medium {{ $isToday ? 'bg-blue-600 text-white rounded-full w-6 h-6 flex items-center justify-center' : ($isCurrentMonth ? 'text-gray-900 dark:text-white' : '') }}">
                                        {{ $currentDate->day }}
                                    </span>
                                </div>

                                <!-- Events for this day -->
                                @foreach($dayEvents->take(3) as $event)
                                    <div class="mb-1 p-1 rounded text-xs bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-100 cursor-pointer hover:bg-blue-200 dark:hover:bg-blue-800"
                                         onclick="showEventModal({{ json_encode($event) }})">
                                        <div class="font-medium truncate">{{ $event['event_name'] }}</div>
                                        <div class="text-xs opacity-75">{{ $event['event_type'] }}</div>
                                    </div>
                                @endforeach

                                @if($dayEvents->count() > 3)
                                    <div class="text-xs text-gray-500 dark:text-gray-400">
                                        +{{ $dayEvents->count() - 3 }} more
                                    </div>
                                @endif
                            </div>

                            @php $currentDate->addDay(); @endphp
                        @endwhile
                    </div>
                </div>
            </div>

            <!-- Upcoming Events Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white mb-4">
                            🚀 Upcoming Events
                        </h3>
                        
                        @if($upcomingEvents->count() > 0)
                            <div class="space-y-4">
                                @foreach($upcomingEvents as $event)
                                    <div class="border border-gray-200 dark:border-gray-600 rounded-lg p-4 hover:shadow-md transition-shadow cursor-pointer"
                                         onclick="showEventModal({{ json_encode($event) }})">
                                        <div class="flex items-start justify-between">
                                            <div class="flex-1">
                                                <h4 class="font-medium text-gray-900 dark:text-white text-sm">
                                                    {{ $event['event_name'] }}
                                                </h4>
                                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                                    {{ \Carbon\Carbon::parse($event['event_date'])->format('M j, Y') }}
                                                </p>
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-100 mt-2">
                                                    {{ $event['event_type'] }}
                                                </span>
                                            </div>
                                        </div>
                                        
                                        @if($event['description'])
                                            <p class="mt-2 text-sm text-gray-600 dark:text-gray-300 line-clamp-2">
                                                {{ Str::limit($event['description'], 100) }}
                                            </p>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500 dark:text-gray-400 text-sm">
                                No upcoming events in the next 30 days.
                            </p>
                        @endif
                    </div>
                </div>

                <!-- Content Ideas Helper -->
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg mt-6">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white mb-4">
                            💡 Content Planning Tips
                        </h3>
                        
                        <div class="space-y-3 text-sm text-gray-600 dark:text-gray-300">
                            <div class="flex items-start">
                                <span class="text-blue-600 mr-2">•</span>
                                <span>Plan content around holidays and special events</span>
                            </div>
                            <div class="flex items-start">
                                <span class="text-blue-600 mr-2">•</span>
                                <span>Use trending hashtags for better reach</span>
                            </div>
                            <div class="flex items-start">
                                <span class="text-blue-600 mr-2">•</span>
                                <span>Schedule posts during peak engagement hours</span>
                            </div>
                            <div class="flex items-start">
                                <span class="text-blue-600 mr-2">•</span>
                                <span>Create series content for consistent posting</span>
                            </div>
                        </div>

                        <div class="mt-4">
                            <a href="{{ route('content.index') }}" 
                               class="w-full text-center block px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                                Generate Content
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Event Modal -->
    <div id="eventModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white dark:bg-gray-800">
            <div class="mt-3">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white" id="modalTitle">Event Details</h3>
                    <button onclick="closeEventModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-white" id="modalDate"></p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Type</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-white" id="modalType"></p>
                    </div>
                    
                    <div id="modalDescriptionDiv">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-white" id="modalDescription"></p>
                    </div>
                    
                    <div id="modalContentIdeasDiv">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Content Ideas</label>
                        <div class="mt-1 text-sm text-gray-900 dark:text-white" id="modalContentIdeas"></div>
                    </div>
                    
                    <div id="modalHashtagsDiv">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Hashtags</label>
                        <div class="mt-1" id="modalHashtags"></div>
                    </div>
                </div>
                
                <div class="flex justify-end mt-6 space-x-3">
                    <button onclick="closeEventModal()" 
                            class="px-4 py-2 bg-gray-300 dark:bg-gray-600 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-md hover:bg-gray-400 dark:hover:bg-gray-500">
                        Close
                    </button>
                    <a href="{{ route('content.index') }}" 
                       class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700">
                        Create Content
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showEventModal(event) {
            document.getElementById('modalTitle').textContent = event.event_name;
            document.getElementById('modalDate').textContent = new Date(event.event_date).toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
            document.getElementById('modalType').textContent = event.event_type;
            
            // Description
            const descDiv = document.getElementById('modalDescriptionDiv');
            const descEl = document.getElementById('modalDescription');
            if (event.description) {
                descEl.textContent = event.description;
                descDiv.style.display = 'block';
            } else {
                descDiv.style.display = 'none';
            }
            
            // Content Ideas
            const ideasDiv = document.getElementById('modalContentIdeasDiv');
            const ideasEl = document.getElementById('modalContentIdeas');
            if (event.content_ideas && event.content_ideas.length > 0) {
                ideasEl.innerHTML = event.content_ideas.map(idea => 
                    `<div class="mb-1 p-2 bg-gray-100 dark:bg-gray-700 rounded text-sm">• ${idea}</div>`
                ).join('');
                ideasDiv.style.display = 'block';
            } else {
                ideasDiv.style.display = 'none';
            }
            
            // Hashtags
            const hashtagsDiv = document.getElementById('modalHashtagsDiv');
            const hashtagsEl = document.getElementById('modalHashtags');
            if (event.hashtags && event.hashtags.length > 0) {
                hashtagsEl.innerHTML = event.hashtags.map(hashtag => 
                    `<span class="inline-block bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-100 px-2 py-1 rounded-full text-xs mr-2 mb-2">#${hashtag}</span>`
                ).join('');
                hashtagsDiv.style.display = 'block';
            } else {
                hashtagsDiv.style.display = 'none';
            }
            
            document.getElementById('eventModal').classList.remove('hidden');
        }
        
        function closeEventModal() {
            document.getElementById('eventModal').classList.add('hidden');
        }
        
        // Close modal when clicking outside
        document.getElementById('eventModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeEventModal();
            }
        });
    </script>
</x-layouts.authenticated>