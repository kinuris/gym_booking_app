<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Browse Gym Classes</title>
    @vite('resources/css/app.css')
    <style>
        body {
            background-color: #18191a;
            color: #e4e6eb;
        }

        .card {
            background-color: #242526;
            border-radius: 8px;
            padding: 16px;
            margin: 8px;
        }

        .card img {
            border-radius: 8px;
        }
    </style>
</head>

<body>
    @include('client.nav')

    <div class="container mx-auto p-4">
        <header class="flex justify-between items-center py-4">
            <h1 class="text-3xl font-bold">Gym Instructors</h1>
            <input type="text" placeholder="Search classes..." class="p-2 rounded bg-gray-700 text-white">
        </header>

        <div class="flex justify-between items-center py-4">
            <div>
                <label for="gender" class="mr-2">Gender:</label>
                <select id="gender" class="p-2 rounded bg-gray-700 text-white">
                    <option value="">All</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>
            </div>
            <div>
                <label for="price-range" class="mr-2">Price Range:</label>
                <input type="range" id="price-range" min="0" max="3000" step="250" value="500" class="slider inline-block w-64" oninput="this.nextElementSibling.value = this.value">
                <output class="ml-2 text-white inline-block">500</output>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($instructors as $instructor)
            <div class="card">
                <img src="{{ asset('storage/' . $instructor->profile_image) }}" alt="Class Image" class="w-full h-96 object-cover">
                <h2 class="text-xl font-bold mt-2">{{ $instructor->fullname }}</h2>
                <p>Age: {{ $instructor->age }} / {{ ucwords($instructor->gender) }}</p>
                <p style="font-size: 12px">Hourly: {{ number_format($instructor->hourly_rate, 2) }} PHP, Monthly: {{ number_format($instructor->monthly_rate, 2) }} PHP</p>
                <div class="flex items-center mt-1">
                    <div id="star-rating-{{ $instructor->id }}" class="flex"></div>

                    <span class="ml-2 text-white">{{ number_format($instructor->stars, 1) }} ({{ count($instructor->sessions) }} {{ count($instructor->sessions) == 1 ? 'session' : 'sessions' }})</span>
                </div>
                <p class="mt-1 text-sm">{{ $instructor->bio }}</p>
                <div class="my-4"></div>
                <a href="/session/schedule/{{ $instructor->id }}" class="p-2 bg-blue-600 text-white rounded">Schedule Session</a>
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
                star.classList.add(i <= rating ? 'text-yellow-400' : 'text-gray-400');
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