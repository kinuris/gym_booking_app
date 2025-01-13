<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Sessions</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-900 text-white">
    @include('instructor.nav')
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold mb-6">My Sessions</h1>
        <div class="grid grid-cols-2 mt-4 gap-4 min-h-screen justify-center items-stretch">
            @foreach ($sessions as $session)
            <div class="flex-1 p-4 min-h-screen bg-gray-800 rounded-lg flex flex-col">
                <div class="flex items-center">
                    <h2 class="text-2xl font-semibold mr-4">{{ $session->client->fullname }}</h2>
                    <p class="{{ $session->status == 'Pending' ? 'text-yellow-500' : ($session->status == 'Canceled' ? 'text-red-500' : 'text-green-500') }}">
                        ({{ $session->status }})
                    </p>

                    @if ($session->status == 'Pending')
                    <div class="flex-1"></div>
                    <form action="/session/start/{{ $session->id }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white text-xs py-1 px-2 rounded">
                            Start Session
                        </button>
                    </form>
                    <form action="/session/cancel/{{ $session->id }}" method="POST" class="ml-2">
                        @csrf
                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white text-xs py-1 px-2 rounded">
                            Cancel
                        </button>
                    </form>
                    @endif
                </div>
                <img src="{{ asset('storage/' . $session->client->profile_image) }}" alt="{{ $session->client->fullname }}" class="w-48 h-48 mt-4 shadow-lg rounded-full object-cover mb-4">

                <p class="text-gray-400">Phone Number: <a href="tel:{{ $session->instructor->phone_number }}" class="text-blue-400">{{ $session->client->phone_number }}</a></p>
                <p class="text-gray-400">Meeting Place: <b>{{ $session->location }}</b> / {{ $session->duration }} {{ $session->type == 'hourly' ? 'hrs.' : 'mos.' }} </p>

                <p class="text-xs mt-4 text-gray-400 mb-1">Shared Note:</p>
                <textarea data-session-id="{{ $session->id }}" class="flex-1 bg-gray-700 text-white p-2 rounded-lg" name="session_notes" id="session_notes" rows="4" placeholder="Enter your notes here..." {{ $session->status == 'Canceled' ? 'readonly' : '' }}>{{ $session->notes }}</textarea>
            </div>
            @endforeach
        </div>
    </div>

    <script>
        document.querySelectorAll('textarea').forEach((e) => e.addEventListener('keydown', function(e) {
            if (e.key === 'Tab') {
                e.preventDefault();
                const start = this.selectionStart;
                const end = this.selectionEnd; // Set textarea value to: text before caret + tab + text after caret
                this.value = this.value.substring(0, start) + "\t" + this.value.substring(end); // Put caret at right position again
                this.selectionStart = this.selectionEnd = start + 1;
            }
        }));
    </script>

    <script>
        document.querySelectorAll('textarea[name="session_notes"]').forEach(textarea => {
            let debounceTimeout;
            textarea.addEventListener('input', function() {
                clearTimeout(debounceTimeout);
                debounceTimeout = setTimeout(async () => {
                    const sessionId = this.getAttribute('data-session-id');
                    const notes = this.value;

                    try {
                        const response = await fetch(`/session/${sessionId}/notes`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                notes
                            })
                        });
                    } catch (error) {
                        console.error('Error saving notes:', error);
                    }
                }, 500);
            });
        });
    </script>
</body>

</html>