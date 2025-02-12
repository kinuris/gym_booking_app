<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-900 text-white">
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

    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-gray-800 p-8 rounded-lg shadow-lg w-96">
            <h1 class="text-2xl font-bold text-white mb-2 text-center">Welcome to Gym Instructor</h1>
            <h2 class="text-xl font-semibold text-cyan-500 mb-6 text-center">Login</h2>

            <form action="/login" method="POST" class="space-y-4">
                @csrf
                <div>
                    <input type="email"
                        name="email"
                        placeholder="Email"
                        required
                        class="w-full p-3 bg-gray-700 rounded border border-gray-600 focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 text-white">
                    @if ($errors->has('email'))
                    <div class="text-red-500 text-sm mt-1">{{ $errors->first('email') }}</div>
                    @endif
                </div>

                <div>
                    <input type="password"
                        name="password"
                        placeholder="Password"
                        required
                        class="w-full p-3 bg-gray-700 rounded border border-gray-600 focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 text-white">
                </div>

                <button type="submit"
                    class="w-full bg-cyan-600 hover:bg-cyan-700 text-white font-bold py-2 px-4 rounded transition duration-300">
                    Login
                </button>

                <button type="button"
                    onclick="window.location.href='/register'"
                    class="w-full bg-gray-700 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded transition duration-300 mt-2">
                    Register as Gym Instructor
                </button>

                <button type="button"
                    onclick="window.location.href='/register-client'"
                    class="w-full bg-gray-700 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded transition duration-300">
                    Register as Client
                </button>
            </form>
        </div>
    </div>
</body>

</html>