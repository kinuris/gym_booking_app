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
    <div class="container mx-auto p-8 max-w-7xl">
        <h1 class="text-4xl font-bold mb-8 text-center text-white border-b border-gray-700 pb-4">My Sessions</h1>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
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
                            <span class="text-gray-400">Location:</span>
                            <span class="font-semibold">{{ $session->location }}</span>
                        </p>
                        <p class="text-gray-300">
                            <span class="text-gray-400">Duration:</span>
                            {{ $session->duration }} {{ $session->type == 'hourly' ? 'hrs.' : 'mos.' }}
                        </p>
                    </div>
                </div>

                <!-- Notes Section -->
                <div class="mb-6">
                    <label class="text-sm text-gray-400 mb-2 block">Shared Notes:</label>
                    <textarea
                        data-session-id="{{ $session->id }}"
                        class="w-full bg-gray-700/50 text-white p-4 rounded-lg resize-none focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        name="session_notes"
                        rows="15"
                        placeholder="Enter your notes here..."
                        {{ $session->status == 'Canceled' ? 'readonly' : '' }}>{{ $session->notes }}</textarea>
                </div>

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