<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instructor Profile</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-800 text-gray-100 m-0 p-0 font-sans">
    @if($notifications->isNotEmpty())
        <div class="fixed top-16 right-5 max-w-[270px] max-h-96 bg-gray-700 p-5 rounded-lg shadow-lg overflow-auto">
            <button onclick="this.parentElement.style.display='none';" class="absolute top-2 right-2 text-gray-100 text-xl cursor-pointer hover:text-gray-300">&times;</button>
            <h2 class="text-blue-400 mb-3">Notifications</h2>
            <ul class="space-y-3">
                @foreach($notifications as $notification)
                    <li class="text-gray-300">
                        <strong class="text-blue-400">{{ $notification->title }}</strong>
                        <p class="mt-1 text-gray-100">{{ $notification->body }}</p>
                        <p class="text-[10px] text-right">{{ $notification->created_at }}</p>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    @include('instructor.nav')

    <div class="max-w-4xl mx-auto mt-24 bg-gray-700 p-8 rounded-lg shadow-lg">
        <div class="mb-8">
            <form action="/instructor/updateprice/{{ $instructor->id }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="hourly_rate" class="block mb-1">Hourly Rate:</label>
                    <input type="text" id="hourly_rate" name="hourly_rate" value="{{ old('hourly_rate', $instructor->hourly_rate) }}" 
                        class="w-full bg-gray-800 text-gray-100 p-2 rounded border border-gray-600 focus:border-blue-400 focus:ring focus:ring-blue-400 focus:ring-opacity-50" required>
                    @error('hourly_rate')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="monthly_rate" class="block mb-1">Monthly Rate:</label>
                    <input type="text" id="monthly_rate" name="monthly_rate" value="{{ old('monthly_rate', $instructor->monthly_rate) }}" 
                        class="w-full bg-gray-800 text-gray-100 p-2 rounded border border-gray-600 focus:border-blue-400 focus:ring focus:ring-blue-400 focus:ring-opacity-50" required>
                    @error('monthly_rate')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded transition duration-200">
                    Update Rates
                </button>
            </form>
        </div>

        <div class="flex gap-8">
            <div class="flex-shrink-0">
                <img src="{{ asset('storage/' . $instructor->profile_image) }}" alt="Profile Picture" 
                    class="w-36 h-36 rounded-full border-3 border-blue-500 object-cover">
            </div>

            <div class="flex-grow">
                <form action="/instructor/updateprofile/{{ $instructor->id }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div class="flex gap-4">
                        <div class="flex-1">
                            <label for="first_name" class="block mb-1">First Name:</label>
                            <input type="text" id="first_name" name="first_name" value="{{ $instructor->first_name }}" 
                                class="w-full bg-gray-800 text-gray-100 p-2 rounded border border-gray-600 focus:border-blue-400 focus:ring focus:ring-blue-400 focus:ring-opacity-50" required>
                        </div>
                        <div class="flex-1">
                            <label for="middle_name" class="block mb-1">Middle Name:</label>
                            <input type="text" id="middle_name" name="middle_name" value="{{ $instructor->middle_name }}" 
                                class="w-full bg-gray-800 text-gray-100 p-2 rounded border border-gray-600 focus:border-blue-400 focus:ring focus:ring-blue-400 focus:ring-opacity-50">
                        </div>
                    </div>

                    <div>
                        <label for="last_name" class="block mb-1">Last Name:</label>
                        <input type="text" id="last_name" name="last_name" value="{{ $instructor->last_name }}" 
                            class="w-full bg-gray-800 text-gray-100 p-2 rounded border border-gray-600 focus:border-blue-400 focus:ring focus:ring-blue-400 focus:ring-opacity-50" required>
                    </div>

                    <div class="flex gap-4">
                        <div class="flex-1">
                            <label for="email" class="block mb-1">Email:</label>
                            <input type="email" id="email" name="email" value="{{ $instructor->email }}" 
                                class="w-full bg-gray-800 text-gray-100 p-2 rounded border border-gray-600 focus:border-blue-400 focus:ring focus:ring-blue-400 focus:ring-opacity-50" required>
                        </div>
                        <div class="flex-1">
                            <label for="phone_number" class="block mb-1">Phone Number:</label>
                            <input type="text" id="phone_number" name="phone_number" value="{{ $instructor->phone_number }}" 
                                class="w-full bg-gray-800 text-gray-100 p-2 rounded border border-gray-600 focus:border-blue-400 focus:ring focus:ring-blue-400 focus:ring-opacity-50" required>
                        </div>
                    </div>

                    <div>
                        <label for="bio" class="block mb-1">Bio:</label>
                        <textarea id="bio" name="bio" rows="4" 
                            class="w-full bg-gray-800 text-gray-100 p-2 rounded border border-gray-600 focus:border-blue-400 focus:ring focus:ring-blue-400 focus:ring-opacity-50" required>{{ $instructor->bio }}</textarea>
                    </div>

                    <div>
                        <label for="profile_image" class="block mb-1">Profile Image:</label>
                        <input type="file" id="profile_image" name="profile_image" 
                            class="w-full bg-gray-800 text-gray-100 p-2 rounded border border-gray-600 focus:border-blue-400 focus:ring focus:ring-blue-400 focus:ring-opacity-50">
                    </div>

                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded transition duration-200">
                        Update Profile
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
