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

    <div class="container mx-auto px-4 py-8">
        <header class="flex flex-col md:flex-row justify-between items-center gap-4 mb-8">
            <h1 class="text-4xl font-bold text-blue-500">Gym Instructors</h1>
            <input type="text" placeholder="Search classes..." 
                class="w-full md:w-64 p-3 rounded-lg bg-gray-800 text-gray-100 border border-gray-700 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:outline-none transition duration-200">
        </header>

        <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-8">
            <div class="w-full md:w-auto">
                <label for="gender" class="text-gray-300 mr-2">Gender:</label>
                <select id="gender" 
                    class="p-3 rounded-lg bg-gray-800 text-gray-100 border border-gray-700 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:outline-none transition duration-200">
                    <option value="">All</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>
            </div>
            <div class="w-full md:w-auto flex items-center gap-4">
                <label for="price-range" class="text-gray-300">Price Range:</label>
                <input type="range" id="price-range" min="0" max="3000" step="250" value="500" 
                    class="w-64 h-2 bg-gray-700 rounded-lg appearance-none cursor-pointer" 
                    oninput="this.nextElementSibling.value = this.value">
                <output class="text-gray-300 min-w-[60px]">500</output>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($instructors as $instructor)
            <div class="bg-gray-800 rounded-xl overflow-hidden shadow-lg transition duration-300 hover:shadow-2xl hover:transform hover:-translate-y-1">
                <img src="{{ asset('storage/' . $instructor->profile_image) }}" 
                    alt="Class Image" 
                    class="w-full h-96 object-cover">
                <div class="p-6">
                    <h2 class="text-2xl font-bold text-blue-400 mb-2">{{ $instructor->fullname }}</h2>
                    <p class="text-gray-300 mb-2">Age: {{ $instructor->age }} / {{ ucwords($instructor->gender) }}</p>
                    <p class="text-sm text-gray-400 mb-3">
                        Hourly: {{ number_format($instructor->hourly_rate, 2) }} PHP
                        <br>Monthly: {{ number_format($instructor->monthly_rate, 2) }} PHP
                    </p>
                    <div class="flex items-center mb-3">
                        <div id="star-rating-{{ $instructor->id }}" class="flex"></div>
                        <span class="ml-2 text-gray-300 text-sm">
                            {{ number_format($instructor->stars, 1) }} 
                            ({{ count($instructor->sessions) }} {{ count($instructor->sessions) == 1 ? 'session' : 'sessions' }})
                        </span>
                    </div>
                    <p class="text-gray-400 text-sm mb-4">{{ $instructor->bio }}</p>
                    <a href="/session/schedule/{{ $instructor->id }}" 
                        class="inline-block w-full text-center py-3 px-4 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200">
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
