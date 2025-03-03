<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-900 text-white">
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

    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="bg-gray-800 p-8 rounded-xl shadow-2xl w-full max-w-md border border-gray-700">
            <div class="mb-8">
                <h1 class="text-2xl font-bold text-white mb-2 text-center">TN Fitness Hub</h1>
                <p class="text-cyan-400 text-center font-medium">Sign in to your account</p>
            </div>
            
            @if(session('error'))
                <div class="bg-red-500 bg-opacity-20 border border-red-500 text-red-300 px-4 py-3 rounded relative mb-6" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <form action="/login" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-300 mb-1">Email Address</label>
                    <input type="email"
                        id="email"
                        name="email"
                        placeholder="your@email.com"
                        required
                        class="w-full p-3 bg-gray-700 rounded-lg border border-gray-600 focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500 focus:ring-opacity-50 text-white placeholder-gray-400 transition duration-300">
                    @if ($errors->has('email'))
                    <div class="text-red-400 text-sm mt-1">{{ $errors->first('email') }}</div>
                    @endif
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-300 mb-1">Password</label>
                    <input type="password"
                        id="password"
                        name="password"
                        placeholder="••••••••"
                        required
                        class="w-full p-3 bg-gray-700 rounded-lg border border-gray-600 focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500 focus:ring-opacity-50 text-white placeholder-gray-400 transition duration-300">
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember_me" name="remember_me" type="checkbox" class="h-4 w-4 text-cyan-500 focus:ring-cyan-500 border-gray-600 rounded bg-gray-700">
                        <label for="remember_me" class="ml-2 block text-sm text-gray-300">Remember me</label>
                    </div>
                    <div class="text-sm">
                        <a href="/forgot-password" class="font-medium text-cyan-400 hover:text-cyan-300">Forgot password?</a>
                    </div>
                </div>

                <button type="submit"
                    class="w-full bg-cyan-600 hover:bg-cyan-700 text-white font-medium py-3 px-4 rounded-lg transition duration-300 flex justify-center items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                    </svg>
                    Sign in
                </button>

                <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-600"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-gray-800 text-gray-400">Or register as</span>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <button type="button"
                        onclick="window.location.href='/register'"
                        class="bg-gray-700 hover:bg-gray-600 text-white font-medium py-3 px-4 rounded-lg transition duration-300 flex items-center justify-center">
                        <span>Instructor</span>
                    </button>

                    <button type="button"
                        onclick="window.location.href='/register-client'"
                        class="bg-gray-700 hover:bg-gray-600 text-white font-medium py-3 px-4 rounded-lg transition duration-300 flex items-center justify-center">
                        <span>Client</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>