<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Sessions</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-900 text-white min-h-screen">
    @include('instructor.nav')

    @php
    $selectedDate = request('selected_date');
    $selectedSession = request('selected_session');
    @endphp

    @if ($selectedDate != null && $selectedSession != null)
    @php
    $existingEvent = \App\Models\SessionEvent::where('coaching_session_id', $selectedSession)
    ->where('event_date', $selectedDate)
    ->first();
    @endphp

    @if($existingEvent)
    <div id="editEventModal" class="fixed inset-0 flex items-center justify-center bg-black/75 backdrop-blur-sm z-50">
        <div class="bg-gray-800/95 rounded-xl shadow-2xl p-8 w-full max-w-lg border border-gray-700 transform transition-all">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-white">Edit Event</h2>
                    <p class="text-gray-400 text-sm mt-1">{{ \Carbon\Carbon::parse($selectedDate)->format('F d, Y') }}</p>
                </div>
                <div class="flex items-center space-x-4">
                    <form action="/session/event/{{ $existingEvent->id }}/delete" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            onclick="return confirm('Are you sure you want to delete this event?')"
                            class="flex items-center px-3 py-2 text-sm font-medium text-red-400 hover:text-red-300 
                                   hover:bg-red-500/10 rounded-lg transition-all duration-200">
                            <svg class="w-5 h-5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Delete
                        </button>
                    </form>
                    <button onclick="toggleEditModal()"
                        class="flex items-center px-3 py-2 text-sm font-medium text-gray-400 hover:text-gray-300 
                               hover:bg-gray-700 rounded-lg transition-all duration-200">
                        <svg class="w-5 h-5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Close
                    </button>
                </div>
            </div>

            <form action="/session/event/{{ $existingEvent->id }}/edit" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-300">Event Category</label>
                    <select name="event_type" class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600 rounded-lg text-white">
                        <option value="Unavailability Notice" {{ $existingEvent->event_type == 'Unavailability Notice' ? 'selected' : '' }}>Unavailability Notice</option>
                        <option value="Other Event" {{ $existingEvent->event_type == 'Other Event' ? 'selected' : '' }}>Other Event</option>
                    </select>
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-300">Description</label>
                    <textarea name="notes" rows="4" class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600 rounded-lg text-white resize-none">{{ $existingEvent->notes }}</textarea>
                </div>

                <div class="flex justify-end space-x-4 pt-4">
                    <button type="button" onclick="toggleEditModal()" class="px-6 py-2.5 rounded-lg border border-gray-600 text-gray-300 hover:bg-gray-700">
                        Cancel
                    </button>
                    <button type="submit" class="px-6 py-2.5 rounded-lg bg-blue-600 text-white font-medium hover:bg-blue-700">
                        Update Event
                    </button>
                </div>
            </form>
        </div>
    </div>
    @else
    <div id="createEventModal" class="fixed inset-0 flex items-center justify-center bg-black/75 backdrop-blur-sm z-50 hidden">
        <div class="bg-gray-800/95 rounded-xl shadow-2xl p-8 w-full max-w-lg border border-gray-700 transform transition-all">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-white">Create New Event</h2>
                    <p class="text-gray-400 text-sm mt-1">For: {{ \Carbon\Carbon::parse($selectedDate)->format('F d, Y') }}</p>
                </div>
                <button onclick="toggleModal()" class="text-gray-400 hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            @if ($errors->any())
            <div class="bg-red-500/10 border border-red-500 rounded-lg p-4 mb-6">
                <ul class="list-disc list-inside text-sm text-red-400">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="/session/{{ $selectedSession }}/event/create" method="POST" class="space-y-6">
                @csrf
                <input type="hidden" name="event_date" value="{{ $selectedDate }}">

                <div class="space-y-2">
                    <label for="category" class="block text-sm font-semibold text-gray-300">Event Category</label>
                    <select name="event_type" id="category"
                        class="w-full px-4 py-3 bg-gray-700/50 border @error('category') border-red-500 @else border-gray-600 @enderror rounded-lg shadow-sm 
                        text-white placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent
                        transition-all duration-200" required>
                        <option value="Unavailability Notice" {{ old('category') == 'Unavailability Notice' ? 'selected' : '' }}>Unavailability Notice</option>
                        <option value="Other Event" {{ old('category') == 'Other Event' ? 'selected' : '' }}>Other Event</option>
                    </select>
                    @error('category')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <label for="notes" class="block text-sm font-semibold text-gray-300">Description</label>
                    <textarea name="notes" id="notes" rows="4"
                        class="w-full px-4 py-3 bg-gray-700/50 border @error('notes') border-red-500 @else border-gray-600 @enderror rounded-lg shadow-sm 
                        text-white placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent
                        transition-all duration-200 resize-none"
                        placeholder="Add some context to help your client understand..." required>{{ old('notes') }}</textarea>
                    @error('notes')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end space-x-4 pt-4">
                    <button type="button"
                        class="px-6 py-2.5 rounded-lg border border-gray-600 text-gray-300 
                        hover:bg-gray-700 hover:text-white transition-all duration-200"
                        onclick="toggleModal()">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-6 py-2.5 rounded-lg bg-blue-600 text-white font-medium
                        hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 
                        focus:ring-offset-gray-800 transition-all duration-200">
                        Create Event
                    </button>
                </div>
            </form>
        </div>
        @endif
    </div>

    <script>
        function toggleModal() {
            const modal = document.getElementById('createEventModal');
            modal.classList.toggle('hidden');
        }

        function toggleEditModal() {
            const modal = document.getElementById('editEventModal');
            modal.classList.toggle('hidden');
        }

        document.addEventListener('DOMContentLoaded', function() {
            toggleModal();
        });
    </script>
    @endif

    <div class="container mx-auto px-4 py-10 max-w-7xl">
        <h1 class="text-4xl font-bold mb-10 text-center lg:text-left">Session Management</h1>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 lg:gap-10">
            @foreach ($sessions as $session)
            <div class="bg-gray-800/90 rounded-2xl shadow-2xl border border-gray-700/50 p-8 transition-all duration-300 hover:shadow-lg hover:shadow-blue-500/10">
                <!-- Header Section -->
                <div class="flex flex-col md:flex-row items-start md:items-center justify-between mb-6 pb-4 border-b border-gray-700/50">
                    <div class="flex flex-col md:flex-row md:items-center md:space-x-4">
                        <h2 class="text-2xl font-bold text-white mb-2 md:mb-0">{{ $session->client->fullname }}</h2>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium shadow-sm
                            {{ $session->status == 'Pending' ? 'bg-yellow-500/20 text-yellow-300 border border-yellow-500/30' : 
                               ($session->status == 'Canceled' ? 'bg-red-500/20 text-red-300 border border-red-500/30' : 'bg-green-500/20 text-green-300 border border-green-500/30') }}">
                            <span class="w-2 h-2 rounded-full mr-1.5
                            {{ $session->status == 'Pending' ? 'bg-yellow-400' : 
                               ($session->status == 'Canceled' ? 'bg-red-400' : 'bg-green-400') }}"></span>
                            {{ $session->status }}
                        </span>
                    </div>

                    <div class="flex items-center gap-3 mt-4 md:mt-0 ml-3">
                        @if ($session->status !== 'Canceled')
                        <form action="/session/cancel/{{ $session->id }}" method="POST" class="inline-block">
                            @csrf
                            <button type="submit" class="bg-red-600/80 hover:bg-red-700 text-xs font-medium text-white px-3 py-1.5 rounded-lg transition-all duration-200 flex items-center gap-1 shadow-sm hover:shadow-md"
                                onclick="return confirm('Are you sure you want to end this session?')">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                End Session
                            </button>
                        </form>

                        @if ($session->status !== 'Accepted')
                        <form action="/session/start/{{ $session->id }}" method="POST" class="inline-block">
                            @csrf
                            <button type="submit"
                                class="bg-emerald-600/90 hover:bg-emerald-700 text-xs font-medium text-white px-3 py-1.5 rounded-lg transition-all duration-200 flex items-center gap-1 shadow-sm hover:shadow-md"
                                onclick="return confirm('Are you sure you want to start this session?')">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Start Session
                            </button>
                        </form>
                        @endif
                        @endif
                    </div>
                </div>

                <!-- Profile Section -->
                <div class="flex flex-col md:flex-row items-center gap-8 mb-8 pb-6 border-b border-gray-700/50">
                    <img src="{{ asset('storage/' . $session->client->profile_image) }}"
                        alt="{{ $session->instructor->fullname }}"
                        class="w-36 h-36 rounded-2xl object-cover border-2 border-gray-600 shadow-xl">
                    <div class="space-y-3 flex-1">
                        <div class="flex items-center gap-3">
                            <div class="bg-gray-700/50 p-2 rounded-lg">
                                <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-gray-400 text-sm">Contact Number</p>
                                <a href="tel:{{ $session->client->phone_number }}" class="text-white font-medium hover:text-blue-400 transition-colors">
                                    {{ $session->client->phone_number }}
                                </a>
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-3">
                            <div class="bg-gray-700/50 p-2 rounded-lg">
                                <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-gray-400 text-sm">Session Duration</p>
                                <p class="text-white font-medium">{{ $session->duration }} {{ $session->duration == 1 ? 'day' : 'days' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Calendar Section -->
                <div>
                    <h3 class="text-lg font-semibold text-white mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Session Calendar
                    </h3>
                    <div class="bg-gray-700/30 rounded-xl p-5 border border-gray-700/50">
                        @php
                        $currentMonth = request('month-' . $session->id) ?
                        \Carbon\Carbon::parse(request('month-' . $session->id)) :
                        \Carbon\Carbon::parse($session->created_at);
                        $startDate = $currentMonth->copy()->startOfMonth();
                        $endDate = $currentMonth->copy()->endOfMonth();
                        $currentDay = $startDate->copy()->startOfWeek();
                        $today = \Carbon\Carbon::now()->format('Y-m-d');
                        $prevMonth = $currentMonth->copy()->subMonth()->format('Y-m');
                        $nextMonth = $currentMonth->copy()->addMonth()->format('Y-m');
                        @endphp

                        <div class="flex justify-between items-center mb-5">
                            <a href="?{{ http_build_query(array_merge(request()->except(['month-' . $session->id, 'selected_date', 'selected_session']), ['month-' . $session->id => $prevMonth])) }}" 
                               class="text-gray-400 hover:text-white bg-gray-700/50 p-2 rounded-lg transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                </svg>
                            </a>
                            <div class="text-xl font-semibold text-white">{{ $currentMonth->format('F Y') }}</div>
                            <a href="?{{ http_build_query(array_merge(request()->except(['month-' . $session->id, 'selected_date', 'selected_session']), ['month-' . $session->id => $nextMonth])) }}" 
                               class="text-gray-400 hover:text-white bg-gray-700/50 p-2 rounded-lg transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>

                        <div class="grid grid-cols-7 gap-2 text-center">
                            <div class="text-gray-400 font-medium pb-2">S</div>
                            <div class="text-gray-400 font-medium pb-2">M</div>
                            <div class="text-gray-400 font-medium pb-2">T</div>
                            <div class="text-gray-400 font-medium pb-2">W</div>
                            <div class="text-gray-400 font-medium pb-2">T</div>
                            <div class="text-gray-400 font-medium pb-2">F</div>
                            <div class="text-gray-400 font-medium pb-2">S</div>
                            @while($currentDay <= $endDate)
                                @php
                                $hasEvent=$session->events()->where('event_date', $currentDay->format('Y-m-d'))->exists();
                                $isStartDate = $currentDay->format('Y-m-d') === date('Y-m-d', strtotime($session->start_date));
                                $isEndDate = $currentDay->format('Y-m-d') === date('Y-m-d', strtotime($session->end_date));
                                $isSessionDay = $currentDay->between(\Carbon\Carbon::parse($session->start_date), \Carbon\Carbon::parse($session->end_date));
                                $isToday = $currentDay->format('Y-m-d') === $today;
                                $isDifferentMonth = $currentDay->month !== $currentMonth->month;
                                @endphp
                                <a href="?{{ http_build_query(array_merge(request()->all(), ['selected_date' => $currentDay->format('Y-m-d'), 'selected_session' => $session->id])) }}" 
                                   class="relative p-2.5 rounded-lg font-medium text-center transition-all
                                {{ !$isSessionDay ? 'pointer-events-none cursor-default' : 'cursor-pointer' }}
                                    {{ $hasEvent ? 'bg-red-500/30 hover:bg-red-500/40 text-white' : 
                                       ($isStartDate || $isEndDate ? 'bg-green-500/80 hover:bg-green-600 text-white' : 
                                       ($isToday ? 'bg-blue-500/80 hover:bg-blue-600 text-white' : 
                                       ($isSessionDay ? 'bg-green-500/20 hover:bg-green-500/30 text-green-300' :
                                       ($isDifferentMonth ? 'bg-gray-800/50 text-gray-500' : 'bg-gray-700/50 hover:bg-gray-700 text-gray-300')))) }}">
                                    {{ $currentDay->format('d') }}
                                    
                                    @if($isStartDate)
                                    <span class="absolute -top-1 left-1/2 transform -translate-x-1/2 bg-green-600 text-xs font-medium px-1.5 py-0.5 rounded text-white">
                                        Start
                                    </span>
                                    @endif
                                    
                                    @if($isEndDate)
                                    <span class="absolute -top-1 left-1/2 transform -translate-x-1/2 bg-green-600 text-xs font-medium px-1.5 py-0.5 rounded text-white">
                                        End
                                    </span>
                                    @endif
                                    
                                    @if($hasEvent)
                                    <span class="absolute -bottom-1 left-1/2 transform -translate-x-1/2 bg-red-600 text-xs font-medium px-1.5 py-0.5 rounded text-white">
                                        Event
                                    </span>
                                    @endif
                                    
                                    @if($isToday && !$isStartDate && !$isEndDate)
                                    <span class="absolute -bottom-1 left-1/2 transform -translate-x-1/2 bg-blue-600 text-xs font-medium px-1.5 py-0.5 rounded text-white">
                                        Today
                                    </span>
                                    @endif
                                </a>
                                @php $currentDay->addDay(); @endphp
                            @endwhile
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <script>
        // Restore month params from localStorage when page loads
        const storedMonthParams = localStorage.getItem('monthParams');
        if (storedMonthParams) {
            const monthParams = JSON.parse(storedMonthParams);
            const currentUrl = new URL(window.location.href);

            for (const [key, value] of Object.entries(monthParams)) {
                if (!currentUrl.searchParams.has(key)) {
                    currentUrl.searchParams.append(key, value);
                }
            }

            if (currentUrl.href !== window.location.href) {
                window.history.pushState({}, '', currentUrl);
                window.location.reload();
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            if (sessionStorage.getItem('scrollPosition')) {
                window.scrollTo(0, sessionStorage.getItem('scrollPosition'));
            }

            window.addEventListener('beforeunload', function() {
                const params = new URLSearchParams(window.location.search);
                const monthParams = {};

                for (const [key, value] of params) {
                    if (key.startsWith('month-')) {
                        monthParams[key] = value;
                    }
                }

                localStorage.setItem('monthParams', JSON.stringify(monthParams));

                sessionStorage.setItem('scrollPosition', window.scrollY);
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (sessionStorage.getItem('scrollPosition')) {
                window.scrollTo(0, sessionStorage.getItem('scrollPosition'));
            }

            window.addEventListener('beforeunload', function() {
                sessionStorage.setItem('scrollPosition', window.scrollY);
            });
        });
    </script>

    <script>
        const sessionNotes = document.querySelectorAll('textarea[name="session_notes"]');
        let debounceTimeout;
        sessionNotes.forEach(textarea => {
            textarea.addEventListener('keydown', function(event) {
                if (event.key === 'Tab') {
                    event.preventDefault();
                    const start = this.selectionStart;
                    const end = this.selectionEnd;
                    this.value = this.value.substring(0, start) + '\t' + this.value.substring(end);
                    this.selectionStart = this.selectionEnd = start + 1;
                }
            });

            textarea.addEventListener('input', function(event) {
                clearTimeout(debounceTimeout);

                const sessionId = this.getAttribute('data-session-id');
                const notes = this.value;

                debounceTimeout = setTimeout(() => {
                    fetch(`/session/${sessionId}/notes`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            notes: notes
                        })
                    });
                }, 500);
            });
        });
    </script>
</body>

</html>