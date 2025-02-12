<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Sessions</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gradient-to-b from-gray-900 to-gray-800 text-white min-h-screen">
    @include('client.nav')

    @if(request()->has('event_id'))
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/75 backdrop-blur-sm">
        <div class="bg-gray-800/95 p-8 rounded-2xl shadow-2xl max-w-2xl w-full mx-4 border border-gray-700">
            @php
            $event = App\Models\SessionEvent::find(request('event_id'));
            @endphp
            @if($event)
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold text-white tracking-tight">Event Details</h3>
                <button onclick="window.location.href='/my/sessions?{{ http_build_query(request()->except('event_id')) }}'"
                    class="text-gray-400 hover:text-white transition-colors duration-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="space-y-6">
                <div class="flex items-center space-x-2">
                    <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <p class="text-lg"><span class="text-gray-400">Date:</span> {{ date('F j, Y', strtotime($event->event_date)) }}</p>
                </div>
                <div class="flex items-center space-x-2">
                    <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <p class="text-lg"><span class="text-gray-400">Event Type:</span> {{ $event->event_type }}</p>
                </div>
                <div class="space-y-2">
                    <div class="flex items-center space-x-2">
                        <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        <span class="text-gray-400 text-lg">Notes:</span>
                    </div>
                    <div class="mt-2 p-4 bg-gray-700/50 rounded-xl whitespace-pre-wrap text-gray-200 shadow-inner">
                        {{ $event->notes ?: 'No notes available.' }}
                    </div>
                </div>
            </div>
            @else
            <div class="flex items-center space-x-3 text-red-400">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="text-lg">Event not found.</p>
            </div>
            @endif
        </div>
    </div>
    @endif

    <div class="container mx-auto p-8 max-w-7xl">
        <h1 class="text-4xl font-bold mb-8 text-center text-white border-b border-gray-700 pb-4">My Sessions</h1>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            @foreach ($sessions as $session)
            <div class="flex flex-col bg-gray-800 rounded-xl shadow-2xl p-6 transition-all duration-300 hover:shadow-lg hover:shadow-blue-500/10">
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
                        <!-- <p class="text-gray-300">
                            <span class="text-gray-400">Location:</span>
                            <span class="font-semibold">{{ $session->location }}</span>
                        </p> -->
                        <p class="text-gray-300">
                            <span class="text-gray-400">Duration:</span>
                            {{ $session->duration }} {{ $session->duration == 1 ? 'day' : 'days' }}
                        </p>

                        <p class="text-gray-300">
                            <span class="text-gray-400">Location:</span>
                            Fitness Hub Gym
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
                            <a href="?{{ http_build_query(array_merge(request()->except('month-' . $session->id), ['month-' . $session->id => $prevMonth])) }}" class="text-gray-400 hover:text-white">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                </svg>
                            </a>
                            <div class="text-lg font-semibold">{{ $currentMonth->format('F Y') }}</div>
                            <a href="?{{ http_build_query(array_merge(request()->except('month-' . $session->id), ['month-' . $session->id => $nextMonth])) }}" class="text-gray-400 hover:text-white">
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
                                $event=$session->events()->where('event_date', $currentDay->format('Y-m-d'))->first();
                                @endphp
                                <div @if ($hasEvent) onclick="viewEvent({{ $event->id }})" @endif class="{{ $hasEvent ? 'cursor-pointer group' : '' }} relative p-2 rounded 
                                    {{ $hasEvent ? ($event->event_type === 'Unavailability Notice' ? 'bg-red-500/50 hover:bg-red-500/70' : 'bg-red-500/50 hover:bg-red-500/70') :
                                       ($currentDay->format('Y-m-d') === $today ? 'bg-blue-500' : 
                                       ($currentDay->format('Y-m-d') === date('Y-m-d', strtotime($session->start_date)) ? 'bg-green-500' : 
                                       ($currentDay->format('Y-m-d') === date('Y-m-d', strtotime($session->end_date)) ? 'bg-green-500' :
                                       ($currentDay->between(\Carbon\Carbon::parse($session->start_date), \Carbon\Carbon::parse($session->end_date)) ? 'bg-green-500/20' :
                                       ($currentDay->month !== $currentMonth->month ? 'bg-gray-800/50' : 'bg-gray-600'))))) }}"
                                    {{ $hasEvent && $event->event_type === 'Unavailability Notice' ? 'data-unavailable=true' : '' }}>
                                    @if($hasEvent && $event->event_type === 'Unavailability Notice')
                                    <div class="absolute -top-14 left-1/2 transform -translate-x-1/2 bg-red-800/95 text-white px-4 py-2 rounded-lg text-sm font-medium whitespace-nowrap scale-0 group-hover:scale-100 transition-all duration-200 shadow-lg border border-red-700/50">
                                        <div class="flex gap-2 items-center justify-center">
                                            <svg class="w-4 h-4 inline-block mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <div class="font-bold mb-1">Unavailable</div>
                                        </div>
                                        <div class="text-red-200 text-xs">{{ $event->notes ?: 'No details provided' }}</div>
                                    </div>
                                    @endif
                                    @if($hasEvent)
                                    @endif
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
                                    @if($currentDay->format('Y-m-d') === $today)
                                    <span class="absolute -bottom-2 left-1/2 transform -translate-x-1/2 bg-blue-600 text-xs font-semibold px-2 py-0.5 rounded-sm">
                                        Today
                                    </span>
                                    @endif
                                    @if($currentDay->format('d') == '01')
                                    <span class="absolute -bottom-2 left-1/2 transform -translate-x-1/2 bg-orange-600 text-xs font-semibold px-2 py-0.5 rounded-sm">
                                        {{ $currentDay->format('M') }}
                                    </span>
                                    @endif
                                    {{ $currentDay->format('d') }}
                                </div>
                                @php $currentDay->addDay(); @endphp
                                @endwhile
                        </div>
                    </div>
                </div>

                <div class="flex-1"></div>

                <!-- Rating Section -->
                <form action="/session/setstars/{{ $session->id }}" method="POST" class="space-y-4">
                    @csrf
                    <label class="text-sm text-gray-400 block">Rate this session:</label>
                    <div class="flex flex-col md:flex-row gap-4">
                        <div class="flex items-center space-x-2">
                            <select name="rating" class="bg-gray-700/50 text-white px-4 py-2 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
                                <option value="" disabled {{ !$session->rating ? 'selected' : '' }}>Rating</option>
                                @for ($i = 1; $i <= 5; $i++)
                                    <option value="{{ $i }}" {{ $session->rating && $session->rating->stars == $i ? 'selected' : '' }}>
                                    {{ str_repeat('⭐', $i) }}
                                    </option>
                                    @endfor
                            </select>
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors duration-200">
                                Submit
                            </button>
                        </div>
                        <input type="text"
                            name="comment"
                            class="flex-1 bg-gray-700/50 text-white px-4 py-2 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                            placeholder="Enter your comment here..."
                            value="{{ $session->rating ? $session->rating->comment : '' }}">
                    </div>
                </form>
            </div>
            @endforeach
        </div>
    </div>

    <script>
        function viewEvent(eventId) {
            const currentParams = new URLSearchParams(window.location.search);

            if (!currentParams.has('event_id')) {
                currentParams.append('event_id', eventId);
            }

            window.location.href = `/my/sessions?${currentParams.toString()}`;
        }
    </script>

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

            textarea.addEventListener('input', function() {
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