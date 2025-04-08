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
        <header class="bg-gray-800 bg-opacity-90 text-white py-5 shadow-lg">
            <div class="container mx-auto flex justify-between items-center px-6">
                <div class="flex items-center gap-4">
                    <img src="{{ asset('assets/logo.jpg') }}" alt="TN Instructor Logo" class="h-14 rounded-full border-2 border-blue-500">
                    <h1 class="text-3xl font-bold tracking-tight">TN <span class="text-blue-400">Fitness Hub</span></h1>
                </div>
                <nav class="hidden md:flex items-center space-x-1">
                    <a href="/" class="px-4 py-2 font-medium hover:text-blue-400 transition duration-300">Home</a>
                    <a href="/login" class="px-4 py-2 font-medium hover:text-blue-400 transition duration-300">Login</a>
                    <a href="/register-client" class="px-4 py-2 font-medium hover:text-blue-400 transition duration-300">Signup</a>
                    <a href="/register" class="px-4 py-2 font-medium hover:text-blue-400 transition duration-300">Become an Instructor</a>
                    <a href="/about" class="px-4 py-2 font-medium hover:text-blue-400 transition duration-300">About</a>
                </nav>
                <button class="md:hidden focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </header>
        
        <main class="container mx-auto mt-16 px-6">
            <section class="text-center py-16">
                <h2 class="text-5xl font-bold mb-6 leading-tight">Welcome to the <span class="text-blue-400">TN Fitness Hub</span></h2>
                <p class="text-xl mb-10 text-gray-300 max-w-2xl mx-auto">Book your gym sessions easily, connect with professional instructors, and transform your fitness journey</p>
                <a href="/login" class="bg-blue-600 text-white px-8 py-4 rounded-lg hover:bg-blue-700 transition duration-300 text-lg font-medium shadow-lg">Get Started Today</a>
            </section>
            <section class="mt-16">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="bg-gray-800 bg-opacity-80 p-8 rounded-xl shadow-lg transform hover:scale-105 transition duration-300">
                        <h3 class="text-2xl font-bold mb-3 text-blue-400">Easy Booking</h3>
                        <p class="text-gray-300 leading-relaxed">Schedule your gym sessions with just a few clicks. Our intuitive platform makes fitness planning effortless.</p>
                    </div>
                    <div class="bg-gray-800 bg-opacity-80 p-8 rounded-xl shadow-lg transform hover:scale-105 transition duration-300">
                        <h3 class="text-2xl font-bold mb-3 text-blue-400">Track Progress</h3>
                        <p class="text-gray-300 leading-relaxed">Monitor your workouts and witness your improvement over time with detailed performance analytics.</p>
                    </div>
                    <div class="bg-gray-800 bg-opacity-80 p-8 rounded-xl shadow-lg transform hover:scale-105 transition duration-300">
                        <h3 class="text-2xl font-bold mb-3 text-blue-400">Stay Motivated</h3>
                        <p class="text-gray-300 leading-relaxed">Join a supportive community of fitness enthusiasts who will help you stay committed to your goals.</p>
                    </div>
                </div>
            </section>

            @if (count($stories) !== 0)
            <section class="mt-20">
                <h2 class="text-3xl font-bold mb-10 text-center">Success Stories</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    @foreach ($stories as $story)
                     <div class="bg-gray-800 bg-opacity-80 p-8 rounded-xl shadow-lg">
                        <div class="flex items-center mb-6">
                            <div class="flex space-x-6">
                                <div class="relative">
                                    <img src="{{ asset('storage/' . $story->image_link_1) }}" alt="Before" class="w-36 h-36 object-cover rounded-lg shadow-md">
                                    <div class="absolute bottom-2 left-2 bg-black bg-opacity-60 text-xs px-2 py-1 rounded">Before</div>
                                </div>
                                @if ($story->image_link_2 != null)
                                <div class="relative">
                                    <img src="{{ asset('storage/' . $story->image_link_2) }}" alt="After" class="w-36 h-36 object-cover rounded-lg shadow-md">
                                    <div class="absolute bottom-2 left-2 bg-black bg-opacity-60 text-xs px-2 py-1 rounded">After</div>
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="mt-4">
                            <h3 class="text-2xl font-bold text-blue-400">{{ $story->title }}</h3>
                            <p class="text-green-400 text-lg mb-2">{{ $story->subtitle }}</p>
                            <p class="text-gray-300 mt-3 italic leading-relaxed">"{{ $story->body }}"</p>
                        </div>
                    </div>   
                    @endforeach
                </div>
            </section>
            @endif

            <section class="mt-20 mb-16">
                <h2 class="text-3xl font-bold mb-10 text-center">Featured Instructors</h2>
                <div class="overflow-x-auto pb-2">
                    <div class="flex space-x-8 pb-4 min-w-max">
                        @php($featured = App\Models\FeaturedInstructor::all()->map(fn($instructor) => $instructor->instructor))
                        @foreach($featured as $instructor)
                        <div class="bg-gray-800 bg-opacity-80 p-6 rounded-xl shadow-lg w-72 transform hover:scale-105 transition duration-300">
                            <div class="relative">
                                <img src="{{ asset('storage/' . $instructor->profile_image) }}" alt="Instructor" class="w-full h-56 object-cover rounded-lg mb-6 shadow-md">
                                @if($instructor->stars >= 4.5)
                                    <div class="absolute top-3 right-3 bg-yellow-500 text-black font-bold px-3 py-1 rounded-full text-sm">Top Rated</div>
                                @endif
                            </div>
                            <h3 class="text-2xl font-bold text-blue-400 mb-2">{{ $instructor->fullname }}</h3>
                            <div class="flex items-center mb-3">
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
                                <span class="ml-2 text-sm">{{ number_format($instructor->stars, 1) }}</span>
                            </div>
                            <div class="flex justify-between text-gray-300 mb-4">
                                <span>Monthly Rate:</span>
                                <span class="font-semibold">₱{{ number_format($instructor->monthly_rate, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-gray-300">
                                <span>Hourly Rate:</span> 
                                <span class="font-semibold">₱{{ number_format($instructor->hourly_rate, 2) }}</span>
                            </div>
                            <a href="/login" class="mt-6 block text-center bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg transition duration-300">View Profile</a>
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