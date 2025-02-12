<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gym Booking App</title>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
</head>

<body class="bg-gray-900 text-gray-100 relative">
    <img class="fixed object-cover w-full h-auto -z-10 opacity-10" src="{{ asset('assets/bg.jpg') }}" alt="Background">
    <div class="absolute z-50 w-full">
        <header class="bg-gray-800 text-white p-4">
            <div class="container mx-auto flex justify-between items-center">
                <div class="flex items-center gap-4">
                    <img src="{{ asset('assets/logo.jpg') }}" alt="TN Instructor Logo" class="h-12 rounded">
                    <h1 class="text-3xl font-bold">TN Fitness Hub</h1>
                </div>
                <nav>
                    <a href="/" class="px-4 hover:text-blue-400">Home</a>
                    <a href="/login" class="px-4 hover:text-blue-400">Login</a>
                    <a href="/register-client" class="px-4 hover:text-blue-400">Signup</a>
                    <a href="/register" class="px-4 hover:text-blue-400">Become an Instructor</a>
                    <a href="/about" class="px-4 hover:text-blue-400">About</a>
                </nav>
            </div>
        </header>
        <main class="container mx-auto mt-10">
            <section class="text-center">
                <h2 class="text-4xl font-bold mb-4">Welcome to the TN Fitness Hub</h2>
                <p class="text-lg mb-8 text-gray-300">Book your gym sessions easily and stay fit!</p>
                <a href="/login" class="bg-blue-600 text-white px-6 py-3 rounded-full hover:bg-blue-700">Get Started</a>
            </section>
            <section class="mt-10">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
                        <h3 class="text-2xl font-bold mb-2 text-blue-400">Easy Booking</h3>
                        <p class="text-gray-300">Book your gym sessions with just a few clicks.</p>
                    </div>
                    <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
                        <h3 class="text-2xl font-bold mb-2 text-blue-400">Track Progress</h3>
                        <p class="text-gray-300">Keep track of your workouts and progress over time.</p>
                    </div>
                    <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
                        <h3 class="text-2xl font-bold mb-2 text-blue-400">Stay Motivated</h3>
                        <p class="text-gray-300">Join a community of fitness enthusiasts.</p>
                    </div>
                </div>
            </section>

            @if (count($stories) !== 0)
            <section class="mt-10">
                <h2 class="text-3xl font-bold mb-6 text-center">Stories</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach ($stories as $story)
                     <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
                        <div class="flex items-center mb-4">
                            <div class="flex space-x-4">
                                <div class="relative">
                                    <img src="{{ asset('storage/' . $story->image_link_1) }}" alt="Before" class="w-32 h-32 object-cover rounded-lg">
                                </div>
                                @if ($story->image_link_2 != null)
                                <div class="relative">
                                    <img src="{{ asset('storage/' . $story->image_link_2) }}" alt="After" class="w-32 h-32 object-cover rounded-lg">
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="mt-4">
                            <h3 class="text-xl font-bold text-blue-400">{{ $story->title }}</h3>
                            <p class="text-green-400">{{ $story->subtitle }}</p>
                            <p class="text-gray-300 mt-2">"{{ $story->body }}"</p>
                        </div>
                    </div>   
                    @endforeach
                </div>
            </section>
            @endif

            <section class="mt-10">
                <h2 class="text-3xl font-bold mb-6 text-center">Featured Instructors</h2>
                <div class="overflow-x-auto">
                    <div class="flex space-x-6 pb-4 min-w-max">
                        @php($featured = App\Models\FeaturedInstructor::all()->map(fn($instructor) => $instructor->instructor))
                        @foreach($featured as $instructor)
                        <div class="bg-gray-800 p-4 rounded-lg shadow-lg w-64">
                            <img src="{{ asset('storage/' . $instructor->profile_image) }}" alt="Instructor" class="w-full h-48 object-cover rounded-lg mb-4">
                            <h3 class="text-xl font-bold text-blue-400">{{ $instructor->fullname }}</h3>
                            <p class="text-gray-300 mt-2">Monthly Rate: ₱{{ number_format($instructor->monthly_rate, 2) }}</p>
                            <p class="text-gray-300">Hourly Rate: ₱{{ number_format($instructor->hourly_rate, 2) }}</p>
                            <div class="flex items-center">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <=$instructor->stars)
                                    <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    @else
                                    <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    @endif
                                @endfor
                                <div class="mx-1"></div>
                                {{ number_format($instructor->stars, 1) }} Stars
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </section>
        </main>
    </div>

    <script>

    </script>
</body>

</html>