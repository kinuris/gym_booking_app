<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Sessions</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-900 text-white">
    @include('client.nav')
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold mb-6">My Sessions</h1>
        <div class="grid grid-cols-2 mt-4 gap-4 min-h-screen justify-center items-stretch">
            @foreach ($sessions as $session)
            <div class="flex-1 p-4 min-h-screen bg-gray-800 rounded-lg flex flex-col">
                <div class="flex items-center">
                    <h2 class="text-2xl font-semibold mr-3">{{ $session->instructor->fullname }}</h2>
                    <p class="{{ $session->status == 'Pending' ? 'text-yellow-500' : ($session->status == 'Canceled' ? 'text-red-500' : 'text-green-500') }}">
                        ({{ $session->status }})
                    </p>
                    <div class="flex-1"></div>
                    <form action="/session/end/{{ $session->id }}" method="POST" class="ml-4">
                        @csrf
                        <button type="submit" class="bg-red-700 text-xs text-white p-1 rounded" onclick="return confirm('Are you sure you want to end this session?')">End Session</button>
                    </form>
                </div>
                <img src="{{ asset('storage/' . $session->instructor->profile_image) }}" alt="{{ $session->instructor->fullname }}" class="w-48 h-48 mt-4 shadow-lg rounded-full object-cover mb-4">

                <p class="text-gray-400">Phone Number: <a href="tel:{{ $session->instructor->phone_number }}" class="text-blue-400">{{ $session->instructor->phone_number }}</a></p>
                <p class="text-gray-400">Meeting Place: <b>{{ $session->location }}</b> / {{ $session->duration }} {{ $session->type == 'hourly' ? 'hrs.' : 'mos.' }}</p>

                <p class="text-xs mt-4 text-gray-400 mb-1">Shared Note:</p>
                <textarea data-session-id="{{ $session->id }}" class="flex-1 bg-gray-700 text-white p-2 rounded-lg" name="session_notes" id="session_notes" rows="4" placeholder="Enter your notes here..." {{ $session->status == 'Canceled' ? 'readonly' : '' }}>{{ $session->notes }}</textarea>

                <form action="/session/setstars/{{ $session->id }}" method="POST" class="mt-4">
                    @csrf
                    <label for="rating" class="block text-gray-400 mb-2">Rate this session:</label>
                    <div class="flex w-full gap-4">
                        <div class="flex items-center">
                            <select name="rating" id="rating" class="bg-gray-700 text-white p-2 mr-2 rounded">
                                <option value="" disabled {{ !$session->rating ? 'selected' : '' }}>Select Rating</option>
                                <option value="1" {{ $session->rating && $session->rating->stars == 1 ? 'selected' : '' }}>⭐</option>
                                <option value="2" {{ $session->rating && $session->rating->stars == 2 ? 'selected' : '' }}>⭐️️⭐</option>
                                <option value="3" {{ $session->rating && $session->rating->stars == 3 ? 'selected' : '' }}>⭐️⭐️⭐️</option>
                                <option value="4" {{ $session->rating && $session->rating->stars == 4 ? 'selected' : '' }}>⭐️⭐️⭐️⭐️</option>
                                <option value="5" {{ $session->rating && $session->rating->stars == 5 ? 'selected' : '' }}>⭐️⭐️⭐️⭐️⭐️</option>
                            </select>
                            <button type="submit" class="bg-blue-500 text-white p-1.5 rounded">Submit</button>
                        </div>
                        @if ($session->rating)
                        <input type="text" name="comment" id="comment" class="bg-gray-700 text-white p-2 rounded w-full" placeholder="Enter your comment here..." value="{{ $session->rating->comment }}">
                        @else
                        <input type="text" name="comment" id="comment" class="bg-gray-700 text-white p-2 rounded w-full" placeholder="Enter your comment here...">
                        @endif
                    </div>
                </form>
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