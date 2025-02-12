<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-900 text-gray-200">
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

    <div class="max-w-2xl mx-auto p-6">
        <div class="bg-gray-800 p-8 rounded-lg shadow-lg">
            <h2 class="text-2xl font-bold mb-6 text-cyan-400">Register as Gym Instructor</h2>

            @if ($errors->any())
            <div class="bg-red-500 text-white p-4 rounded-lg mb-6">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="/register" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                <div>
                    <label for="first_name" class="block text-cyan-400 font-bold mb-2">First Name</label>
                    <input type="text" id="first_name" name="first_name" value="{{ old('first_name') }}" required
                        class="w-full bg-gray-700 text-gray-200 border border-gray-600 rounded-lg p-3 focus:outline-none focus:border-cyan-400">
                </div>

                <div>
                    <label for="middle_name" class="block text-cyan-400 font-bold mb-2">Middle Name</label>
                    <input type="text" id="middle_name" name="middle_name" value="{{ old('middle_name') }}" required
                        class="w-full bg-gray-700 text-gray-200 border border-gray-600 rounded-lg p-3 focus:outline-none focus:border-cyan-400">
                </div>

                <div>
                    <label for="last_name" class="block text-cyan-400 font-bold mb-2">Last Name</label>
                    <input type="text" id="last_name" name="last_name" value="{{ old('last_name') }}" required
                        class="w-full bg-gray-700 text-gray-200 border border-gray-600 rounded-lg p-3 focus:outline-none focus:border-cyan-400">
                </div>

                <div>
                    <label for="email" class="block text-cyan-400 font-bold mb-2">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required
                        class="w-full bg-gray-700 text-gray-200 border border-gray-600 rounded-lg p-3 focus:outline-none focus:border-cyan-400">
                </div>

                <div>
                    <label for="password" class="block text-cyan-400 font-bold mb-2">Password</label>
                    <input type="password" id="password" name="password" required
                        class="w-full bg-gray-700 text-gray-200 border border-gray-600 rounded-lg p-3 focus:outline-none focus:border-cyan-400">
                </div>

                <div>
                    <label for="confirm_password" class="block text-cyan-400 font-bold mb-2">Confirm Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" required
                        class="w-full bg-gray-700 text-gray-200 border border-gray-600 rounded-lg p-3 focus:outline-none focus:border-cyan-400">
                </div>

                <div>
                    <label for="birthdate" class="block text-cyan-400 font-bold mb-2">Birthdate</label>
                    <input type="date" id="birthdate" name="birthdate" value="{{ old('birthdate') }}" required
                        class="w-full bg-gray-700 text-gray-200 border border-gray-600 rounded-lg p-3 focus:outline-none focus:border-cyan-400">
                </div>

                <div>
                    <label for="profile_image" class="block text-cyan-400 font-bold mb-2">Profile Image</label>
                    <input type="file" id="profile_image" name="profile_image" required
                        class="w-full bg-gray-700 text-gray-200 border border-gray-600 rounded-lg p-2 focus:outline-none focus:border-cyan-400">
                </div>

                <div>
                    <label for="phone_number" class="block text-cyan-400 font-bold mb-2">Phone Number</label>
                    <input type="text" id="phone_number" name="phone_number" value="{{ old('phone_number') }}" required
                        class="w-full bg-gray-700 text-gray-200 border border-gray-600 rounded-lg p-3 focus:outline-none focus:border-cyan-400">
                </div>

                <div>
                    <label for="bio" class="block text-cyan-400 font-bold mb-2">Bio</label>
                    <textarea id="bio" name="bio" rows="4" required
                        class="w-full bg-gray-700 text-gray-200 border border-gray-600 rounded-lg p-3 focus:outline-none focus:border-cyan-400">{{ old('bio') }}</textarea>
                </div>

                <div>
                    <label for="rate_hourly" class="block text-cyan-400 font-bold mb-2">Hourly Rate (PHP)</label>
                    <input type="number" id="rate_hourly" name="hourly_rate" value="{{ old('rate_hourly') }}" required
                        class="w-full bg-gray-700 text-gray-200 border border-gray-600 rounded-lg p-3 focus:outline-none focus:border-cyan-400">
                </div>

                <div>
                    <label for="rate_monthly" class="block text-cyan-400 font-bold mb-2">Monthly Rate (PHP)</label>
                    <input type="number" id="rate_monthly" name="monthly_rate" value="{{ old('rate_monthly') }}" required
                        class="w-full bg-gray-700 text-gray-200 border border-gray-600 rounded-lg p-3 focus:outline-none focus:border-cyan-400">
                </div>

                <div>
                    <label for="gender" class="block text-cyan-400 font-bold mb-2">Gender</label>
                    <select id="gender" name="gender" required
                        class="w-full bg-gray-700 text-gray-200 border border-gray-600 rounded-lg p-3 focus:outline-none focus:border-cyan-400">
                        <option value="" disabled selected>Select your gender</option>
                        <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                    </select>
                </div>

                <div>
                    <button type="submit"
                        class="w-full bg-cyan-500 text-white py-3 px-6 rounded-lg font-semibold hover:bg-cyan-600 transition duration-300">
                        Register
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>