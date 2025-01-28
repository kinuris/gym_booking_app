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
    <div class="container mx-auto px-4 py-8 max-w-7xl">
        <h1 class="text-4xl font-bold mb-8 text-center lg:text-left">My Sessions</h1>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8">
            @foreach ($sessions as $session)
            <div class="bg-gray-800 rounded-xl shadow-xl p-6 hover:bg-gray-750 transition duration-300">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-2xl font-bold">{{ $session->client->fullname }}</h2>
                    <span class="px-3 py-1 rounded-full text-sm font-medium {{ 
                        $session->status == 'Pending' ? 'bg-yellow-500/20 text-yellow-400' : 
                        ($session->status == 'Canceled' ? 'bg-red-500/20 text-red-400' : 'bg-green-500/20 text-green-400') 
                    }}">
                        {{ $session->status }}
                    </span>
                </div>

                @if ($session->status == 'Pending')
                <div class="flex gap-2 mb-4">
                    <form action="/session/start/{{ $session->id }}" method="POST" class="flex-1">
                        @csrf
                        <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200">
                            Start Session
                        </button>
                    </form>
                    <form action="/session/cancel/{{ $session->id }}" method="POST" class="flex-1">
                        @csrf
                        <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200">
                            Cancel Session
                        </button>
                    </form>
                </div>
                @endif

                <div class="flex flex-col md:flex-row items-center gap-6 mb-6">
                    <img src="{{ asset('storage/' . $session->client->profile_image) }}"
                        alt="{{ $session->client->fullname }}"
                        class="w-32 h-32 rounded-full object-cover shadow-lg ring-2 ring-gray-700">
                    <div class="space-y-2">
                        <p class="text-gray-300">
                            <span class="text-gray-400">Phone:</span>
                            <a href="tel:{{ $session->instructor->phone_number }}" class="text-blue-400 hover:text-blue-300">
                                {{ $session->client->phone_number }}
                            </a>
                        </p>
                        <p class="text-gray-300">
                            <span class="text-gray-400">Location:</span>
                            <span class="font-semibold">{{ $session->location }}</span>
                        </p>
                        <p class="text-gray-300">
                            <span class="text-gray-400">Duration:</span>
                            <span class="font-semibold">{{ $session->duration }} {{ $session->type == 'hourly' ? 'hrs.' : 'mos.' }}</span>
                        </p>
                    </div>
                </div>

                <div class="space-y-2">
                    <label for="session_notes" class="text-sm font-medium text-gray-400">Session Notes:</label>
                    <textarea
                        data-session-id="{{ $session->id }}"
                        class="w-full bg-gray-700 text-white p-3 rounded-lg resize-none focus:ring-2 focus:ring-blue-500 focus:outline-none {{ $session->status == 'Canceled' ? 'opacity-75' : '' }}"
                        name="session_notes"
                        rows="15"
                        placeholder="Enter your notes here..."
                        {{ $session->status == 'Canceled' ? 'readonly' : '' }}>{{ $session->notes }}</textarea>
                </div>
            </div>
            @endforeach
        </div>
    </div>

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