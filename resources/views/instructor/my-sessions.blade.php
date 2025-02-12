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

    <div class="container mx-auto px-4 py-8 max-w-7xl">
        <h1 class="text-4xl font-bold mb-8 text-center lg:text-left">My Sessions</h1>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8">
            @foreach ($sessions as $session)
            <div class="bg-gray-800 rounded-xl shadow-2xl p-6 transition-all duration-300 hover:shadow-lg hover:shadow-blue-500/10">
                <!-- Header Section -->
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center space-x-4">
                        <h2 class="text-2xl font-bold text-white">{{ $session->instructor->fullname }}</h2>
                        <span class="px-3 py-1 rounded-full text-sm font-medium 
                            {{ $session->status == 'Pending' ? 'bg-yellow-500/20 text-yellow-400' : 
                               ($session->status == 'Canceled' ? 'bg-red-500/20 text-red-400' : 'bg-green-500/20 text-green-400') }}">
                            {{ $session->status }}
                        </span>
                    </div>
                    <form action="/session/end/{{ $session->id }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-sm text-white px-4 py-2 rounded-lg transition-colors duration-200"
                            onclick="return confirm('Are you sure you want to end this session?')">
                            End Session
                        </button>
                    </form>
                </div>

                <!-- Profile Section -->
                <div class="flex flex-col md:flex-row items-center gap-6 mb-6">
                    <img src="{{ asset('storage/' . $session->instructor->profile_image) }}"
                        alt="{{ $session->instructor->fullname }}"
                        class="w-32 h-32 rounded-full object-cover border-4 border-gray-700 shadow-xl">
                    <div class="space-y-2">
                        <p class="text-gray-300">
                            <span class="text-gray-400">Phone:</span>
                            <a href="tel:{{ $session->instructor->phone_number }}" class="text-blue-400 hover:text-blue-300">
                                {{ $session->instructor->phone_number }}
                            </a>
                        </p>
                        <p class="text-gray-300">
                            <span class="text-gray-400">Duration:</span>
                            {{ $session->duration }} {{ $session->duration == 1 ? 'day' : 'days' }}
                        </p>
                    </div>
                </div>

                <!-- Calendar Section -->
                <div class="mb-6">
                    <label class="text-sm text-gray-400 mb-2 block">Session Calendar:</label>
                    <div class="bg-gray-700/50 rounded-lg p-4">
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

                        <div class="flex justify-between items-center mb-4">
                            <a href="?{{ http_build_query(array_merge(request()->except(['month-' . $session->id, 'selected_date', 'selected_session']), ['month-' . $session->id => $prevMonth])) }}" class="text-gray-400 hover:text-white">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                </svg>
                            </a>
                            <div class="text-lg font-semibold">{{ $currentMonth->format('F Y') }}</div>
                            <a href="?{{ http_build_query(array_merge(request()->except(['month-' . $session->id, 'selected_date', 'selected_session']), ['month-' . $session->id => $nextMonth])) }}" class="text-gray-400 hover:text-white">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>

                        <div class="grid grid-cols-7 gap-2 text-center text-sm">
                            <div class="text-gray-400">Sun</div>
                            <div class="text-gray-400">Mon</div>
                            <div class="text-gray-400">Tue</div>
                            <div class="text-gray-400">Wed</div>
                            <div class="text-gray-400">Thu</div>
                            <div class="text-gray-400">Fri</div>
                            <div class="text-gray-400">Sat</div>
                            @while($currentDay <= $endDate)
                                @php
                                $hasEvent=$session->events()->where('event_date', $currentDay->format('Y-m-d'))->exists();
                                @endphp
                                <a href="?{{ http_build_query(array_merge(request()->all(), ['selected_date' => $currentDay->format('Y-m-d'), 'selected_session' => $session->id])) }}" class="relative p-2 rounded block text-center 
                                    {{ $hasEvent ? 'bg-red-500/50 hover:bg-red-500/60' : 
                                       ($currentDay->format('Y-m-d') === $today ? 'bg-blue-500 hover:bg-blue-600' : 
                                       ($currentDay->format('Y-m-d') === date('Y-m-d', strtotime($session->start_date)) ? 'bg-green-500 hover:bg-green-600' : 
                                       ($currentDay->format('Y-m-d') === date('Y-m-d', strtotime($session->end_date)) ? 'bg-green-500 hover:bg-green-600' :
                                       ($currentDay->between(\Carbon\Carbon::parse($session->start_date), \Carbon\Carbon::parse($session->end_date)) ? 'bg-green-500/20 hover:bg-green-500/30' :
                                       ($currentDay->month !== $currentMonth->month ? 'bg-gray-800/50 hover:bg-gray-800/60' : 'bg-gray-600 hover:bg-gray-700'))))) }}"
                                    {{ !$currentDay->between(\Carbon\Carbon::parse($session->start_date), \Carbon\Carbon::parse($session->end_date)) ? 'onclick="e.preventDefault()"' : '' }}>
                                    @if($currentDay->format('Y-m-d') === date('Y-m-d', strtotime($session->start_date)))
                                    <span class="absolute -top-2 left-1/2 transform -translate-x-1/2 bg-green-600 text-xs font-semibold px-2 py-0.5 rounded-sm">
                                        Start
                                    </span>
                                    @endif
                                    @if($currentDay->format('Y-m-d') === date('Y-m-d', strtotime($session->end_date)))
                                    <span class="absolute -top-2 left-1/2 transform -translate-x-1/2 bg-green-600 text-xs font-semibold px-2 py-0.5 rounded-sm">
                                        End
                                    </span>
                                    @endif
                                    @if($hasEvent)
                                    <span class="absolute -bottom-2 left-1/2 transform -translate-x-1/2 bg-red-600 text-xs font-semibold px-2 py-0.5 rounded-sm">
                                        Event
                                    </span>
                                    @endif
                                    {{ $currentDay->format('d') }}
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