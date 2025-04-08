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

        <main class="container mx-auto mt-10 px-4">
            <div class="max-w-4xl mx-auto bg-gray-800 bg-opacity-90 p-8 rounded-lg shadow-lg mb-8 border border-gray-700">
                <h2 class="text-3xl font-bold mb-8 text-blue-400 border-b border-gray-700 pb-4">About TN Fitness Hub</h2>
                <div class="space-y-6">
                    <p class="text-lg leading-relaxed">
                        Welcome to TN Fitness Hub Booking System, your all-in-one platform for seamless gym and fitness class reservations. Designed to enhance convenience and efficiency, our system ensures that members can easily schedule workouts, book classes, and manage their fitness journey with just a few clicks.
                    </p>
                    <div class="my-8 bg-gray-700 bg-opacity-50 p-6 rounded-md border-l-4 border-blue-400">
                        <h3 class="text-xl font-semibold mb-4 text-blue-400">Our Mission</h3>
                        <p class="leading-relaxed">At TN Fitness Hub, we strive to provide a user-friendly and efficient booking experience that empowers fitness enthusiasts to stay committed to their health goals. Our platform bridges the gap between fitness centers and members by offering a hassle-free scheduling system that saves time and enhances accessibility.</p>
                    </div>
                    <p class="text-gray-400 border-t border-gray-700 pt-6 text-center italic">
                        Join us today and start your journey towards a healthier lifestyle with TN Fitness Hub.
                    </p>

                    <div class="mt-10 border-t border-gray-700 pt-6">
                        <h3 class="text-xl font-semibold mb-4 text-blue-400">Connect With Us</h3>
                        <div class="flex flex-wrap items-center justify-center gap-6">
                            <a href="tel:+1234567890" class="flex items-center gap-2 text-gray-300 hover:text-blue-400 transition duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                                <span>(123) 456-7890</span>
                            </a>
                            <a href="https://facebook.com/tnfitnesshub" target="_blank" class="flex items-center gap-2 text-gray-300 hover:text-blue-400 transition duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z" />
                                </svg>
                                <span>TN Fitness Hub</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>

</html>