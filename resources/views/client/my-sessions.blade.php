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

    @if(request()->has('progress_date'))
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/80 backdrop-blur-md">
        <div class="bg-gradient-to-br from-gray-800 to-gray-900 p-8 rounded-2xl shadow-2xl max-w-2xl w-full mx-4 border border-gray-700/60">
            <div class="flex justify-between items-center mb-6 pb-4 border-b border-gray-700/50">
                <h3 class="text-2xl font-bold text-white tracking-tight flex items-center">
                    <svg class="w-6 h-6 mr-2 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    Record Daily Progress
                </h3>
                <button onclick="window.location.href='/my/sessions?{{ http_build_query(request()->except(['progress_date', 'progress_event_id'])) }}'"
                    class="text-gray-400 hover:text-white transition-colors duration-200 p-2 rounded-full hover:bg-gray-700/50">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form action="{{ route('progress.store') }}" method="POST" class="space-y-6">
                @csrf
                <input type="hidden" name="coaching_session_id" value="{{ request('progress_event_id') }}">
                <input type="hidden" name="client_id" value="{{ Auth::guard('client')->user()->id }}">

                <div class="bg-gray-800/40 p-4 rounded-xl border border-gray-700/40 shadow-inner mb-6">
                    <div class="flex items-center space-x-2">
                        <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span class="text-xl font-semibold text-white">{{ date('F j, Y', strtotime(request('progress_date'))) }}</span>
                    </div>
                    <input type="hidden" name="date" value="{{ request('progress_date') }}">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="flex items-center text-gray-300 text-sm font-medium">
                            <svg class="w-4 h-4 mr-2 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Start Time
                        </label>
                        <input type="time" name="start_time" required
                            class="w-full bg-gray-700/30 text-white px-4 py-3 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none border border-gray-600 transition-all duration-200">
                    </div>

                    <div class="space-y-2">
                        <label class="flex items-center text-gray-300 text-sm font-medium">
                            <svg class="w-4 h-4 mr-2 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            End Time
                        </label>
                        <input type="time" name="end_time" required
                            class="w-full bg-gray-700/30 text-white px-4 py-3 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none border border-gray-600 transition-all duration-200">
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="flex items-center text-gray-300 text-sm font-medium">
                        <svg class="w-4 h-4 mr-2 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" />
                        </svg>
                        Weight (kg)
                    </label>
                    <input type="number" name="weight" step="0.1" required
                        class="w-full bg-gray-700/30 text-white px-4 py-3 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none border border-gray-600 transition-all duration-200">
                </div>

                <button type="submit"
                    class="w-full mt-4 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-500 hover:to-blue-600 text-white px-6 py-3 rounded-xl transition-all duration-300 font-medium shadow-lg hover:shadow-blue-500/30 flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Submit Progress
                </button>
            </form>
        </div>
    </div>
    @endif

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

    <div class="container mx-auto px-4 py-12 max-w-7xl">
        <h1 class="text-4xl font-bold mb-10 text-white border-b border-gray-700 pb-6 text-center">My Training Sessions</h1>

        @if(count($sessions) == 0)
        <div class="bg-gray-800/80 rounded-xl p-8 text-center shadow-lg">
            <svg class="w-16 h-16 mx-auto text-gray-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            <h3 class="text-xl font-semibold text-gray-300 mb-2">No Active Sessions</h3>
            <p class="text-gray-400 mb-6">You don't have any training sessions scheduled at the moment.</p>
            <a href="/client/browse" class="inline-flex items-center justify-center px-5 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-all duration-200 shadow-lg hover:shadow-blue-500/30">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Book a Session
            </a>
        </div>
        @else
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
            @foreach ($sessions as $session)
            <div class="flex flex-col bg-gradient-to-br from-gray-800 to-gray-900 rounded-xl shadow-xl border border-gray-700/50 overflow-hidden transition-all duration-300 hover:shadow-2xl hover:shadow-blue-500/10">
                <!-- Header Section -->
                <div class="bg-gradient-to-r from-gray-800 to-gray-900 px-6 py-5 border-b border-gray-700/70">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <h2 class="text-2xl font-bold text-white tracking-tight">{{ $session->instructor->fullname }}</h2>
                            <span class="px-3 py-1 rounded-full text-xs font-medium 
                                    {{ $session->status == 'Pending' ? 'bg-yellow-500/20 text-yellow-400 border border-yellow-500/30' : 
                                    ($session->status == 'Canceled' ? 'bg-red-500/20 text-red-400 border border-red-500/30' : 'bg-green-500/20 text-green-400 border border-green-500/30') }}">
                                {{ $session->status }}
                            </span>
                        </div>

                        @if ($session->status !== 'Canceled')
                        <form action="/session/end/{{ $session->id }}" method="POST">
                            @csrf
                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition-all duration-200 shadow-md hover:shadow-red-600/30 text-sm font-medium flex items-center"
                                onclick="return confirm('Are you sure you want to end this session?')">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                End Session
                            </button>
                        </form>
                        @endif
                    </div>
                </div>

                <div class="p-6 flex-1">
                    <!-- Profile Section -->
                    <div class="flex flex-col md:flex-row items-center gap-6 mb-8">
                        <div class="relative">
                            <img src="{{ asset('storage/' . $session->instructor->profile_image) }}"
                                alt="{{ $session->instructor->fullname }}"
                                class="w-32 h-32 rounded-full object-cover border-4 border-blue-500/20 shadow-xl">
                            <div class="absolute -bottom-2 -right-2 bg-blue-600 rounded-full w-8 h-8 flex items-center justify-center shadow-lg">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                        </div>

                        <div class="space-y-3">
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                                <a href="tel:{{ $session->instructor->phone_number }}" class="text-blue-400 hover:text-blue-300 transition-colors duration-200">
                                    {{ $session->instructor->phone_number }}
                                </a>
                            </div>
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <span class="text-gray-300">{{ $session->duration }} {{ $session->duration == 1 ? 'day' : 'days' }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <span class="text-gray-300">Fitness Hub Gym</span>
                            </div>
                        </div>
                    </div>

                    <!-- Calendar Section -->
                    <div class="mb-8">
                        <div class="flex items-center gap-2 mb-3">
                            <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <h3 class="text-lg font-semibold text-gray-200">Session Schedule</h3>
                        </div>

                        <div class="bg-gray-800/50 rounded-xl p-4 border border-gray-700/50 shadow-inner">
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

                            <div class="flex justify-between items-center mb-6">
                                <a href="?{{ http_build_query(array_merge(request()->except('month-' . $session->id), ['month-' . $session->id => $prevMonth])) }}"
                                    class="text-gray-400 hover:text-white p-2 rounded-full hover:bg-gray-700/50 transition-all duration-200">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                    </svg>
                                </a>
                                <div class="text-lg font-semibold text-gray-200">{{ $currentMonth->format('F Y') }}</div>
                                <a href="?{{ http_build_query(array_merge(request()->except('month-' . $session->id), ['month-' . $session->id => $nextMonth])) }}"
                                    class="text-gray-400 hover:text-white p-2 rounded-full hover:bg-gray-700/50 transition-all duration-200">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            </div>

                            <div class="grid grid-cols-7 gap-2 text-center text-sm">
                                @foreach(['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $day)
                                <div class="text-gray-400 font-medium mb-2">{{ $day }}</div>
                                @endforeach

                                @while($currentDay <= $endDate)
                                    @php
                                    $hasEvent=$session->events()->where('event_date', $currentDay->format('Y-m-d'))->exists();
                                    $event = $session->events()->where('event_date', $currentDay->format('Y-m-d'))->first();
                                    $progressRecord = $session->progressRecords()->where('date', $currentDay->format('Y-m-d'))->first();
                                    @endphp
                                    <div @if ($hasEvent) onclick="viewEvent({{ $event->id }})" @endif
                                        @if(!$hasEvent && !$progressRecord && $currentDay->between(\Carbon\Carbon::parse($session->start_date), \Carbon\Carbon::now()) && $currentDay->gte(\Carbon\Carbon::parse($session->start_date)))
                                        onclick="progressForm({{ $session->id }}, '{{ $currentDay->format('Y-m-d') }}')"
                                        @endif
                                        class="{{ $hasEvent || $currentDay->between(\Carbon\Carbon::parse($session->start_date), \Carbon\Carbon::now()) ? 'cursor-pointer group' : '' }}
                                        relative p-2 rounded-lg transition-all duration-200
                                        {{ $hasEvent ? ($event->event_type === 'Unavailability Notice' ? 'bg-red-500/20 border border-red-500/30 hover:bg-red-500/30' : 
                                                    'bg-blue-500/20 border border-blue-500/30 hover:bg-blue-500/30') :
                                                    ($currentDay->format('Y-m-d') === $today ? 'bg-blue-500 text-white font-bold shadow-lg shadow-blue-500/30' : 
                                                    ($currentDay->format('Y-m-d') === date('Y-m-d', strtotime($session->start_date)) ? 'bg-green-500 text-white font-bold shadow-lg shadow-green-500/30' : 
                                                    ($currentDay->format('Y-m-d') === date('Y-m-d', strtotime($session->end_date)) ? 'bg-green-500 text-white font-bold shadow-lg shadow-green-500/30' :
                                                    ($currentDay->between(\Carbon\Carbon::parse($session->start_date), \Carbon\Carbon::parse($session->end_date)) ? 
                                                        'bg-green-500/10 border border-green-500/30 hover:bg-green-500/20' :
                                                    ($currentDay->month !== $currentMonth->month ? 'bg-gray-800/50 text-gray-500' : 
                                                        'bg-gray-700/30 hover:bg-gray-700/50'))))) }}">

                                        @if($hasEvent && $event->event_type === 'Unavailability Notice')
                                        <div class="absolute -top-16 left-1/2 transform -translate-x-1/2 bg-gray-900/95 text-white px-4 py-2 rounded-lg text-sm font-medium whitespace-nowrap scale-0 group-hover:scale-100 transition-all duration-200 shadow-xl border border-red-700/50 z-10">
                                            <div class="flex gap-2 items-center justify-center">
                                                <svg class="w-4 h-4 inline-block text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                <div class="font-bold text-red-300">Unavailable</div>
                                            </div>
                                            <div class="text-red-200 text-xs mt-1">{{ $event->notes ?: 'No details provided' }}</div>
                                            <div class="absolute bottom-0 left-1/2 transform -translate-x-1/2 translate-y-1/2 rotate-45 w-3 h-3 bg-gray-900 border-r border-b border-red-700/50"></div>
                                        </div>
                                        @endif

                                        @if($currentDay->format('Y-m-d') === date('Y-m-d', strtotime($session->start_date)))
                                        <span class="absolute -top-2 left-1/2 transform -translate-x-1/2 bg-green-600 text-xs font-semibold px-2 py-0.5 rounded-full shadow-lg">
                                            Start
                                        </span>
                                        @endif

                                        @if($currentDay->format('Y-m-d') === date('Y-m-d', strtotime($session->end_date)))
                                        <span class="absolute -top-2 left-1/2 transform -translate-x-1/2 bg-green-600 text-xs font-semibold px-2 py-0.5 rounded-full shadow-lg">
                                            End
                                        </span>
                                        @endif

                                        @if($hasEvent)
                                        <span class="absolute -bottom-2 left-1/2 transform -translate-x-1/2 bg-blue-600 text-xs font-semibold px-2 py-0.5 rounded-full shadow-lg">
                                            Event
                                        </span>
                                        @endif

                                        @if(!$progressRecord && $currentDay->lt(\Carbon\Carbon::now()) && $currentDay->gt(\Carbon\Carbon::parse($session->start_date)) && $currentDay->format('Y-m-d') !== $today && !$hasEvent)
                                        <div class="absolute -top-1 -left-1 flex items-center justify-center">
                                            <div class="w-3 h-3 bg-red-500 rounded-full shadow-lg ring-2 ring-red-400/30"
                                                title="Missing progress for {{ $currentDay->format('M j') }}">
                                                <div class="w-full h-full rounded-full bg-red-400/50 animate-ping opacity-75"></div>
                                            </div>
                                        </div>
                                        <div class="absolute -top-16 left-1/2 transform -translate-x-1/2 bg-gray-900/95 text-white px-4 py-2 rounded-lg text-sm font-medium whitespace-nowrap opacity-0 group-hover:opacity-100 scale-95 group-hover:scale-100 transition-all duration-300 ease-in-out shadow-xl border border-red-700/50 z-10">
                                            <div class="flex gap-2 items-center justify-center">
                                                <svg class="w-4 h-4 inline-block text-red-400 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                                </svg>
                                                <div class="font-bold text-red-300">Missing Progress</div>
                                            </div>
                                            <div class="text-red-200 text-xs mt-1">Click to add missed progress</div>
                                            <div class="absolute bottom-0 left-1/2 transform -translate-x-1/2 translate-y-1/2 rotate-45 w-3 h-3 bg-gray-900 border-r border-b border-red-700/50"></div>
                                        </div>
                                        @endif

                                        @if($progressRecord)
                                        <div class="absolute -top-1 -left-1 flex items-center justify-center">
                                            <div class="w-3 h-3 bg-cyan-500 rounded-full shadow-lg ring-2 ring-cyan-400/30"
                                                title="Progress recorded for {{ date('F j, Y', strtotime($progressRecord->date)) }}">
                                                <div class="w-full h-full rounded-full bg-cyan-400/50 scale-110 animate-pulse"></div>
                                            </div>
                                        </div>
                                        <div class="absolute -top-16 left-1/2 transform -translate-x-1/2 bg-gray-900/95 text-white px-4 py-2 rounded-lg text-sm font-medium whitespace-nowrap scale-0 group-hover:scale-100 transition-all duration-200 shadow-xl border border-cyan-700/50 z-10">
                                            <div class="flex gap-2 items-center justify-center">
                                                <svg class="w-4 h-4 inline-block text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                <div class="font-bold text-cyan-300">Progress Recorded</div>
                                            </div>
                                            <div class="text-cyan-200 text-xs mt-1">
                                                {{ $progressRecord->weight }}kg • {{ \Carbon\Carbon::parse($progressRecord->start_time)->format('g:ia') }} - {{ \Carbon\Carbon::parse($progressRecord->end_time)->format('g:ia') }}
                                            </div>
                                            <div class="absolute bottom-0 left-1/2 transform -translate-x-1/2 translate-y-1/2 rotate-45 w-3 h-3 bg-gray-900 border-r border-b border-cyan-700/50"></div>
                                        </div>
                                        @endif

                                        @if($currentDay->format('Y-m-d') === $today && !$progressRecord && $currentDay->between(\Carbon\Carbon::parse($session->start_date), \Carbon\Carbon::now()) && !$hasEvent)
                                        <div class="absolute -top-1 -left-1 flex items-center justify-center">
                                            <div class="w-3 h-3 bg-amber-500 rounded-full shadow-lg ring-2 ring-amber-400/30 animate-pulse"
                                                title="Progress needed for today">
                                                <div class="w-full h-full rounded-full bg-amber-400/50 scale-110 animate-ping"></div>
                                            </div>
                                        </div>
                                        <div class="absolute -top-16 left-1/2 transform -translate-x-1/2 bg-gray-900/95 text-white px-4 py-2 rounded-lg text-sm font-medium whitespace-nowrap scale-0 group-hover:scale-100 transition-all duration-200 shadow-xl border border-amber-700/50 z-10">
                                            <div class="flex gap-2 items-center justify-center">
                                                <svg class="w-4 h-4 inline-block text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                                </svg>
                                                <div class="font-bold text-amber-300">Progress Needed</div>
                                            </div>
                                            <div class="text-amber-200 text-xs mt-1">Click to add today's progress</div>
                                            <div class="absolute bottom-0 left-1/2 transform -translate-x-1/2 translate-y-1/2 rotate-45 w-3 h-3 bg-gray-900 border-r border-b border-amber-700/50"></div>
                                        </div>
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
                    <form action="/session/setstars/{{ $session->id }}" method="POST" class="mt-6">
                        @csrf
                        <div class="flex items-center gap-2 mb-3">
                            <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                            </svg>
                            <h3 class="text-lg font-semibold text-gray-200">Rate Your Experience</h3>
                        </div>
                        <div class="bg-gray-800/50 rounded-xl p-4 border border-gray-700/50 shadow-inner">
                            <div class="flex flex-col md:flex-row gap-4">
                                <div class="flex items-center space-x-2">
                                    <select name="rating" class="bg-gray-700 text-white px-4 py-2 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none border border-gray-600">
                                        <option value="" disabled {{ !$session->rating ? 'selected' : '' }}>Rating</option>
                                        @for ($i = 1; $i <= 5; $i++)
                                            <option value="{{ $i }}" {{ $session->rating && $session->rating->stars == $i ? 'selected' : '' }}>
                                            {{ str_repeat('⭐', $i) }}
                                            </option>
                                            @endfor
                                    </select>
                                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-all duration-200 shadow-md hover:shadow-blue-600/30 font-medium">
                                        Submit
                                    </button>
                                </div>
                                <input type="text"
                                    name="comment"
                                    class="flex-1 bg-gray-700 text-white px-4 py-2 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none border border-gray-600"
                                    placeholder="Share your feedback..."
                                    value="{{ $session->rating ? $session->rating->comment : '' }}">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>

    <script>
        function viewEvent(eventId) {
            const currentParams = new URLSearchParams(window.location.search);

            if (!currentParams.has('event_id')) {
                currentParams.append('event_id', eventId);
            }

            window.location.href = `/my/sessions?${currentParams.toString()}`;
        }

        function progressForm(event, date) {
            const currentParams = new URLSearchParams(window.location.search);

            if (!currentParams.has('progress_date')) {
                currentParams.append('progress_date', date);
            }

            if (!currentParams.has('progress_event_id')) {
                currentParams.append('progress_event_id', event);
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