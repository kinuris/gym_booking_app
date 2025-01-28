<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>Schedule Session</title>
</head>

<body class="bg-gradient-to-b from-gray-900 to-gray-800 text-white min-h-screen">
    @include('client.nav')
    <div class="max-w-xl mx-auto my-12 bg-gray-800/50 backdrop-blur-sm shadow-2xl rounded-xl overflow-hidden border border-gray-700">
        <div class="flex justify-center mt-8">
            <div class="relative">
                <img class="object-cover w-48 h-48 rounded-full shadow-xl border-4 border-gray-700" 
                     src="{{ asset('storage/' . $instructor->profile_image) }}" 
                     alt="Instructor Profile Image">
                <div class="absolute -bottom-2 left-1/2 transform -translate-x-1/2 bg-blue-600 px-4 py-1 rounded-full text-sm font-semibold">
                    Instructor
                </div>
            </div>
        </div>
        <div class="p-8">
            <h2 class="text-center text-2xl font-bold text-blue-400">{{ $instructor->fullname }}</h2>
            <p class="text-center text-gray-400 mt-2 italic">{{ $instructor->bio }}</p>
        </div>

        <div class="px-8 pb-8">
            <div class="flex justify-center mb-6 gap-4">
                <button id="monthlyButton" class="bg-gray-700 hover:bg-blue-600 transition-colors duration-300 flex-1 text-white font-bold py-3 px-6 rounded-lg shadow-lg">
                    Monthly Plan
                </button>
                <button id="hourlyButton" class="bg-gray-700 hover:bg-blue-600 transition-colors duration-300 flex-1 text-white font-bold py-3 px-6 rounded-lg shadow-lg">
                    Hourly Plan
                </button>
            </div>

            <div id="monthlyRateForm" class="rate-form hidden space-y-6">
                <h3 class="text-center text-xl font-bold text-blue-400">Monthly Rate 
                    <span class="text-green-400">({{ number_format($instructor->monthly_rate, 2) }} PHP)</span>
                </h3>
                <form action="/session/schedule/monthly" method="POST" class="space-y-4">
                    @csrf
                    <input type="hidden" name="instructor_id" value="{{ $instructor->id }}">
                    <div class="space-y-2">
                        <label for="monthly_rate" class="block text-gray-300 font-medium">Duration (In Months)</label>
                        <input type="text" id="monthly_rate" name="duration" 
                               class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600 text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300">
                    </div>
                    <div class="space-y-2">
                        <label for="meeting_place" class="block text-gray-300 font-medium">Meeting Place</label>
                        <input type="text" id="meeting_place" name="location" 
                               class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600 text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300">
                    </div>
                    <div class="flex justify-center pt-4">
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-8 rounded-lg shadow-lg transition-colors duration-300">
                            Schedule Session
                        </button>
                    </div>
                </form>
            </div>

            <div id="hourlyRateForm" class="rate-form hidden space-y-6">
                <h3 class="text-center text-xl font-bold text-blue-400">Hourly Rate 
                    <span class="text-green-400">({{ number_format($instructor->hourly_rate, 2) }} PHP)</span>
                </h3>
                <form action="/session/schedule/hourly" method="POST" class="space-y-4">
                    @csrf
                    <input type="hidden" name="instructor_id" value="{{ $instructor->id }}">
                    <div class="space-y-2">
                        <label for="hourly_rate" class="block text-gray-300 font-medium">Duration (In Hours)</label>
                        <input type="text" id="hourly_rate" name="duration" 
                               class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600 text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300">
                    </div>
                    <div class="space-y-2">
                        <label for="meeting_place" class="block text-gray-300 font-medium">Meeting Place</label>
                        <input type="text" id="meeting_place" name="location" 
                               class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600 text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300">
                    </div>
                    <div class="flex justify-center pt-4">
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-8 rounded-lg shadow-lg transition-colors duration-300">
                            Schedule Session
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <script>
            document.getElementById('monthlyButton').addEventListener('click', function() {
                document.getElementById('monthlyRateForm').classList.remove('hidden');
                document.getElementById('hourlyRateForm').classList.add('hidden');
                this.classList.add('bg-blue-600');
                this.classList.remove('bg-gray-700');
                document.getElementById('hourlyButton').classList.add('bg-gray-700');
                document.getElementById('hourlyButton').classList.remove('bg-blue-600');
            });

            document.getElementById('hourlyButton').addEventListener('click', function() {
                document.getElementById('hourlyRateForm').classList.remove('hidden');
                document.getElementById('monthlyRateForm').classList.add('hidden');
                this.classList.add('bg-blue-600');
                this.classList.remove('bg-gray-700');
                document.getElementById('monthlyButton').classList.add('bg-gray-700');
                document.getElementById('monthlyButton').classList.remove('bg-blue-600');
            });
        </script>
    </div>
</body>

</html>