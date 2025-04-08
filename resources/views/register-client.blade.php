<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-900 text-gray-200">
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

    <div class="max-w-2xl mx-auto p-6 my-12">
        <div class="bg-gray-800 p-10 rounded-xl shadow-2xl border border-gray-700">
            <h2 class="text-3xl font-bold mb-8 text-cyan-400 border-b border-gray-700 pb-4">Register as Client</h2>

            <form action="/register-client" method="POST" enctype="multipart/form-data">
                @csrf
                @if ($errors->any())
                <div class="bg-red-500 bg-opacity-80 text-white p-4 rounded-lg mb-6 shadow">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="first_name" class="block text-cyan-400 font-medium mb-2">First Name</label>
                        <input type="text" id="first_name" name="first_name" value="{{ old('first_name') }}" required
                            class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-cyan-400 focus:border-transparent transition duration-200">
                    </div>

                    <div>
                        <label for="last_name" class="block text-cyan-400 font-medium mb-2">Last Name</label>
                        <input type="text" id="last_name" name="last_name" value="{{ old('last_name') }}" required
                            class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-cyan-400 focus:border-transparent transition duration-200">
                    </div>

                    <div>
                        <label for="middle_name" class="block text-cyan-400 font-medium mb-2">Middle Name</label>
                        <input type="text" id="middle_name" name="middle_name" value="{{ old('middle_name') }}"
                            class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-cyan-400 focus:border-transparent transition duration-200">
                    </div>

                    <div>
                        <label for="phone_number" class="block text-cyan-400 font-medium mb-2">Phone Number</label>
                        <input type="text" id="phone_number" name="phone_number" value="{{ old('phone_number') }}" required
                            class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-cyan-400 focus:border-transparent transition duration-200">
                    </div>

                    <div class="md:col-span-2">
                        <label for="email" class="block text-cyan-400 font-medium mb-2">Email Address</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required
                            class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-cyan-400 focus:border-transparent transition duration-200">
                    </div>

                    <div>
                        <label for="password" class="block text-cyan-400 font-medium mb-2">Password</label>
                        <input type="password" id="password" name="password" required
                            class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-cyan-400 focus:border-transparent transition duration-200">
                    </div>

                    <div>
                        <label for="confirm_password" class="block text-cyan-400 font-medium mb-2">Confirm Password</label>
                        <input type="password" id="confirm_password" name="confirm_password" required
                            class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-cyan-400 focus:border-transparent transition duration-200">
                    </div>

                    <div>
                        <label for="birthdate" class="block text-cyan-400 font-medium mb-2">Birthdate</label>
                        <input type="date" id="birthdate" name="birthdate" value="{{ old('birthdate') }}" required
                            class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-cyan-400 focus:border-transparent transition duration-200">
                    </div>

                    <div>
                        <label for="gender" class="block text-cyan-400 font-medium mb-2">Gender</label>
                        <select id="gender" name="gender" required
                            class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-cyan-400 focus:border-transparent transition duration-200">
                            <option value="" disabled selected>Select your gender</option>
                            <option value="Male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                        </select>
                    </div>

                    <div class="md:col-span-2">
                        <label for="profile_image" class="block text-cyan-400 font-medium mb-2">Profile Image</label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-600 border-dashed rounded-lg">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-400">
                                    <label for="profile_image" class="relative cursor-pointer bg-gray-700 rounded-md font-medium text-cyan-400 hover:text-cyan-300 focus-within:outline-none">
                                        <span class="px-2">Upload a file</span>
                                        <input id="profile_image" name="profile_image" type="file" class="sr-only" required>
                                    </label>
                                    <p class="pl-1">or drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-400">
                                    PNG, JPG, GIF up to 10MB
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-8 pt-6 border-t border-gray-700">
                    <button type="submit"
                        class="w-full bg-cyan-500 text-white font-bold py-3 px-4 rounded-lg hover:bg-cyan-600 focus:outline-none focus:ring-2 focus:ring-cyan-400 focus:ring-offset-2 focus:ring-offset-gray-900 transition duration-200">
                        Create Account
                    </button>
                </div>

                <p class="mt-4 text-center text-gray-400">
                    Already have an account? <a href="/login" class="text-cyan-400 hover:text-cyan-300">Sign in</a>
                </p>
            </form>
        </div>
    </div>
</body>

</html>