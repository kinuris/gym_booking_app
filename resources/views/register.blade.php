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

    <div class="max-w-3xl mx-auto py-10 px-6">
        <div class="bg-gray-800 p-10 rounded-xl shadow-2xl border border-gray-700">
            <h2 class="text-3xl font-bold mb-8 text-cyan-400 text-center">Instructor Registration</h2>
            
            @if ($errors->any())
            <div class="bg-red-500/80 text-white p-4 rounded-lg mb-6 backdrop-blur-sm">
                <div class="flex items-center mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                    <span class="font-semibold">Please correct the following errors:</span>
                </div>
                <ul class="list-disc list-inside ml-2">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="/register" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="grid md:grid-cols-2 gap-6 mb-8">
                    <div>
                        <label for="first_name" class="block text-cyan-400 font-medium mb-2">First Name</label>
                        <input type="text" id="first_name" name="first_name" value="{{ old('first_name') }}" required
                            class="w-full bg-gray-700 text-gray-200 border border-gray-600 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-cyan-400 transition duration-200">
                    </div>

                    <div>
                        <label for="middle_name" class="block text-cyan-400 font-medium mb-2">Middle Name</label>
                        <input type="text" id="middle_name" name="middle_name" value="{{ old('middle_name') }}"
                            class="w-full bg-gray-700 text-gray-200 border border-gray-600 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-cyan-400 transition duration-200">
                    </div>

                    <div>
                        <label for="last_name" class="block text-cyan-400 font-medium mb-2">Last Name</label>
                        <input type="text" id="last_name" name="last_name" value="{{ old('last_name') }}" required
                            class="w-full bg-gray-700 text-gray-200 border border-gray-600 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-cyan-400 transition duration-200">
                    </div>

                    <div>
                        <label for="email" class="block text-cyan-400 font-medium mb-2">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required
                            class="w-full bg-gray-700 text-gray-200 border border-gray-600 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-cyan-400 transition duration-200">
                    </div>

                    <div>
                        <label for="password" class="block text-cyan-400 font-medium mb-2">Password</label>
                        <input type="password" id="password" name="password" required
                            class="w-full bg-gray-700 text-gray-200 border border-gray-600 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-cyan-400 transition duration-200">
                    </div>

                    <div>
                        <label for="confirm_password" class="block text-cyan-400 font-medium mb-2">Confirm Password</label>
                        <input type="password" id="confirm_password" name="confirm_password" required
                            class="w-full bg-gray-700 text-gray-200 border border-gray-600 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-cyan-400 transition duration-200">
                    </div>

                    <div>
                        <label for="birthdate" class="block text-cyan-400 font-medium mb-2">Birthdate</label>
                        <input type="date" id="birthdate" name="birthdate" value="{{ old('birthdate') }}" required
                            class="w-full bg-gray-700 text-gray-200 border border-gray-600 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-cyan-400 transition duration-200">
                    </div>

                    <div>
                        <label for="gender" class="block text-cyan-400 font-medium mb-2">Gender</label>
                        <select id="gender" name="gender" required
                            class="w-full bg-gray-700 text-gray-200 border border-gray-600 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-cyan-400 transition duration-200">
                            <option value="" disabled selected>Select your gender</option>
                            <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                        </select>
                    </div>

                    <div>
                        <label for="phone_number" class="block text-cyan-400 font-medium mb-2">Phone Number</label>
                        <input type="text" id="phone_number" name="phone_number" value="{{ old('phone_number') }}" required
                            class="w-full bg-gray-700 text-gray-200 border border-gray-600 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-cyan-400 transition duration-200">
                    </div>
                </div>
                
                <div class="mb-6">
                    <label for="profile_image" class="block text-cyan-400 font-medium mb-2">Profile Image</label>
                    <div class="border-2 border-dashed border-gray-600 rounded-lg p-4 text-center">
                        <input type="file" id="profile_image" name="profile_image" required
                            class="w-full bg-gray-700 text-gray-200 p-2 focus:outline-none">
                        <p class="text-gray-400 text-sm mt-2">JPG, PNG or GIF (Max. 2MB)</p>
                    </div>
                </div>

                <div class="mb-6">
                    <label for="bio" class="block text-cyan-400 font-medium mb-2">Professional Bio</label>
                    <textarea id="bio" name="bio" rows="4" required
                        class="w-full bg-gray-700 text-gray-200 border border-gray-600 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-cyan-400 transition duration-200">{{ old('bio') }}</textarea>
                    <p class="text-gray-400 text-sm mt-1">Describe your experience, qualifications, and training philosophy</p>
                </div>

                <div class="grid md:grid-cols-2 gap-6 mb-8">
                    <div>
                        <label for="rate_hourly" class="block text-cyan-400 font-medium mb-2">Hourly Rate (PHP)</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">₱</span>
                            <input type="number" id="rate_hourly" name="hourly_rate" value="{{ old('rate_hourly') }}" required
                                class="w-full bg-gray-700 text-gray-200 border border-gray-600 rounded-lg p-3 pl-8 focus:outline-none focus:ring-2 focus:ring-cyan-400 transition duration-200">
                        </div>
                    </div>

                    <div>
                        <label for="rate_monthly" class="block text-cyan-400 font-medium mb-2">Monthly Rate (PHP)</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">₱</span>
                            <input type="number" id="rate_monthly" name="monthly_rate" value="{{ old('rate_monthly') }}" required
                                class="w-full bg-gray-700 text-gray-200 border border-gray-600 rounded-lg p-3 pl-8 focus:outline-none focus:ring-2 focus:ring-cyan-400 transition duration-200">
                        </div>
                    </div>
                </div>

                <div class="mt-8">
                    <button type="submit"
                        class="w-full bg-gradient-to-r from-cyan-500 to-blue-600 text-white py-3 px-6 rounded-lg font-bold hover:from-cyan-600 hover:to-blue-700 transition duration-300 shadow-lg">
                        Register as Instructor
                    </button>
                    <p class="text-center text-gray-400 text-sm mt-4">
                        Already have an account? <a href="/login" class="text-cyan-400 hover:underline">Login here</a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</body>

</html>