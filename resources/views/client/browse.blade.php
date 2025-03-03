<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Browse Gym Classes</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-900 text-gray-100 min-h-screen">
    @include('client.nav')

    <div class="container mx-auto px-4 py-12">
        <header class="flex flex-col md:flex-row justify-between items-center gap-6 mb-10">
            <h1 class="text-4xl font-extrabold text-blue-400 tracking-tight">Gym Instructors</h1>
            <div class="relative w-full md:w-72">
                <input type="text" placeholder="Search instructors..." 
                    class="w-full p-3 pl-10 rounded-lg bg-gray-800 text-gray-100 border border-gray-700 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:outline-none transition duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 absolute left-3 top-3.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
        </header>

        <div class="flex flex-col md:flex-row justify-between items-center gap-6 mb-10 bg-gray-800/50 p-5 rounded-xl shadow-md">
            <div class="w-full md:w-auto">
                <label for="gender" class="text-gray-300 font-medium block mb-2">Filter by Gender</label>
                <select id="gender" 
                    class="p-3 rounded-lg bg-gray-800 text-gray-100 border border-gray-700 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:outline-none transition duration-200">
                    <option value="">All Genders</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>
            </div>
            <div class="w-full md:w-auto">
                <label for="price-range" class="text-gray-300 font-medium block mb-2">Maximum Hourly Rate (PHP)</label>
                <div class="flex items-center gap-4">
                    <input type="range" id="price-range" min="0" max="3000" step="250" value="500" 
                        class="w-64 h-2 bg-gray-700 rounded-lg appearance-none cursor-pointer accent-blue-500" 
                        oninput="this.nextElementSibling.value = this.value + ' PHP'">
                    <output class="text-gray-300 min-w-[80px] bg-gray-800 p-2 rounded-md text-center">500 PHP</output>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            @foreach($instructors as $instructor)
            <div class="bg-gray-800 rounded-xl overflow-hidden shadow-lg transition-all duration-300 hover:shadow-blue-900/20 hover:shadow-2xl hover:transform hover:-translate-y-2 border border-gray-700/50">
                <div class="relative">
                    <img src="{{ asset('storage/' . $instructor->profile_image) }}" 
                        alt="{{ $instructor->fullname }}" 
                        class="w-full h-80 object-cover">
                    <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-gray-900 to-transparent h-24"></div>
                </div>
                <div class="p-6">
                    <div class="flex justify-between items-start mb-3">
                        <h2 class="text-2xl font-bold text-blue-400">{{ $instructor->fullname }}</h2>
                        <span class="bg-blue-600/20 text-blue-400 px-2 py-1 rounded text-xs font-semibold">
                            {{ ucwords($instructor->gender) }}
                        </span>
                    </div>
                    <div class="flex items-center mb-4">
                        <div id="star-rating-{{ $instructor->id }}" class="flex"></div>
                        <span class="ml-2 text-gray-300 text-sm">
                            {{ number_format($instructor->stars, 1) }} 
                            <span class="text-gray-500">({{ count($instructor->sessions) }})</span>
                        </span>
                    </div>
                    <div class="grid grid-cols-2 gap-2 mb-4">
                        <div class="bg-gray-700/50 rounded-lg p-3 text-center">
                            <p class="text-xs text-gray-400">Hourly</p>
                            <p class="text-lg font-bold text-white">₱{{ number_format($instructor->hourly_rate, 0) }}</p>
                        </div>
                        <div class="bg-gray-700/50 rounded-lg p-3 text-center">
                            <p class="text-xs text-gray-400">Monthly</p>
                            <p class="text-lg font-bold text-white">₱{{ number_format($instructor->monthly_rate, 0) }}</p>
                        </div>
                    </div>
                    <p class="text-gray-400 text-sm mb-6 line-clamp-3">{{ $instructor->bio }}</p>
                    <a href="/session/schedule/{{ $instructor->id }}" 
                        class="inline-block w-full text-center py-3 px-4 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200 font-medium">
                        Schedule Session
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <script>
        function generateStars(id, rating) {
            const starContainer = document.getElementById(id);
            starContainer.innerHTML = '';
            for (let i = 1; i <= 5; i++) {
                const star = document.createElement('span');
                star.classList.add('text-2xl', i <= rating ? 'text-yellow-400' : 'text-gray-600');
                star.innerHTML = '&#9733;';
                starContainer.appendChild(star);
            }
        }

        <?php foreach ($instructors as $instructor): ?>
            generateStars('star-rating-{{ $instructor->id }}', <?php echo $instructor->stars ?>);
        <?php endforeach ?>
    </script>
</body>

</html>
