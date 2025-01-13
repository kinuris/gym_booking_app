<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>Schedule Session</title>
</head>

<body class="bg-gray-900 text-white">
    @include('client.nav')
    <div class="max-w-sm mx-auto my-8 bg-gray-800 shadow-lg rounded-lg overflow-hidden">
        <div class="flex justify-center mt-4">
            <img class="object-cover w-64 h-64 rounded-full shadow-lg" src="{{ asset('storage/' . $instructor->profile_image) }}" alt="Instructor Profile Image">
        </div>
        <div class="p-6">
            <h2 class="text-center text-xl font-semibold">{{ $instructor->fullname }}</h2>
            <p class="text-center text-gray-400">{{ $instructor->bio }}</p>
        </div>

        <div class="p-6">
            <div class="flex justify-center mb-4">
                <button id="monthlyButton" class="bg-gray-500 flex-1 text-white font-bold py-2 px-4 rounded mr-2">
                    Monthly
                </button>
                <button id="hourlyButton" class="bg-gray-500 flex-1 text-white font-bold py-2 px-4 rounded">
                    Hourly
                </button>
            </div>
            <div id="monthlyRateForm" class="rate-form hidden">
                <h3 class="text-center text-lg font-semibold">Monthly Rate ({{ number_format($instructor->monthly_rate, 2) }} PHP)</h3>
                <form action="/session/schedule/monthly" method="POST">
                    @csrf
                    <input type="hidden" name="instructor_id" value="{{ $instructor->id }}">
                    <div class="mb-4 mt-4">
                        <label for="monthly_rate" class="block text-gray-400">Duration (In Months)</label>
                        <input type="text" id="monthly_rate" name="duration" class="w-full px-3 py-2 bg-gray-700 text-white rounded">
                    </div>
                    <div class="mb-4 mt-4">
                        <label for="meeting_place" class="block text-gray-400">Meeting Place</label>
                        <input type="text" id="meeting_place" name="location" class="w-full px-3 py-2 bg-gray-700 text-white rounded">
                    </div>
                    <div class="flex justify-center">
                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                            Submit
                        </button>
                    </div>
                </form>
            </div>
            <div id="hourlyRateForm" class="rate-form hidden">
                <h3 class="text-center text-lg font-semibold">Hourly Rate ({{ number_format($instructor->hourly_rate, 2) }}) PHP</h3>
                <form action="/session/schedule/hourly" method="POST">
                    @csrf
                    <input type="hidden" name="instructor_id" value="{{ $instructor->id }}">
                    <div class="mb-4 mt-4">
                        <label for="hourly_rate" class="block text-gray-400">Duration (In Hours)</label>
                        <input type="text" id="hourly_rate" name="duration" class="w-full px-3 py-2 bg-gray-700 text-white rounded">
                    </div>
                    <div class="mb-4 mt-4">
                        <label for="meeting_place" class="block text-gray-400">Meeting Place</label>
                        <input type="text" id="meeting_place" name="location" class="w-full px-3 py-2 bg-gray-700 text-white rounded">
                    </div>
                    <div class="flex justify-center">
                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <script>
            document.getElementById('monthlyButton').addEventListener('click', function() {
                document.getElementById('monthlyRateForm').classList.remove('hidden');
                document.getElementById('hourlyRateForm').classList.add('hidden');
                this.classList.add('bg-blue-700');
                this.classList.remove('bg-blue-500');
                document.getElementById('hourlyButton').classList.add('bg-gray-500');
                document.getElementById('hourlyButton').classList.remove('bg-blue-700');
            });

            document.getElementById('hourlyButton').addEventListener('click', function() {
                document.getElementById('hourlyRateForm').classList.remove('hidden');
                document.getElementById('monthlyRateForm').classList.add('hidden');
                this.classList.add('bg-blue-700');
                this.classList.remove('bg-gray-500');
                document.getElementById('monthlyButton').classList.add('bg-gray-500');
                document.getElementById('monthlyButton').classList.remove('bg-blue-700');
            });
        </script>
    </div>
</body>

</html>