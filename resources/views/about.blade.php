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
        <div class="max-w-3xl mx-auto bg-gray-800 p-8 rounded-lg shadow-lg mb-4">
            <h2 class="text-3xl font-bold mb-6 text-blue-400">About TN Fitness Hub</h2>
            <div class="space-y-6">
                <p class="text-lg">
                    Welcome to TN Fitness Hub Booking System, your all-in-one platform for seamless gym and fitness class reservations. Designed to enhance convenience and efficiency, our system ensures that members can easily schedule workouts, book classes, and manage their fitness journey with just a few clicks.
                </p>
                <div class="mb-6">
                    <h3 class="text-xl font-semibold mb-3 text-blue-400">Our Mission</h3>
                    <p>At TN Fitness Hub, we strive to provide a user-friendly and efficient booking experience that empowers fitness enthusiasts to stay committed to their health goals. Our platform bridges the gap between fitness centers and members by offering a hassle-free scheduling system that saves time and enhances accessibility.</p>
                </div>
                <p class="text-sm text-gray-400">
                    Join us today and start your journey towards a healthier lifestyle with TN Fitness Hub.
                </p>
            </div>
        </div>
        </main>
    </div>
</body>

</html>
