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
        <div class="fixed top-16 right-5 max-w-sm max-h-[450px] bg-gray-700 p-5 rounded-lg shadow-xl overflow-auto border border-gray-600 z-50">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-blue-400 font-semibold text-lg">Notifications</h2>
                <button onclick="this.closest('div.fixed').style.display='none';" class="text-gray-400 hover:text-gray-200 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
            <ul class="space-y-4 divide-y divide-gray-600">
                @foreach($notifications as $notification)
                    <li class="pt-3 first:pt-0">
                        <h3 class="text-blue-400 font-medium">{{ $notification->title }}</h3>
                        <p class="mt-1 text-gray-300 text-sm">{{ $notification->body }}</p>
                        <p class="text-xs text-gray-400 mt-2">{{ $notification->created_at->diffForHumans() }}</p>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    @include('instructor.nav')
    <div class="max-w-5xl mx-auto mt-16 mb-12 bg-gradient-to-b from-gray-700 to-gray-800 rounded-xl shadow-2xl overflow-hidden">
        <div class="bg-gray-600 px-8 py-4 border-b border-gray-500">
            <h1 class="text-2xl font-bold text-white">Instructor Profile</h1>
        </div>
        
        <div class="p-8">
            <!-- Pricing Section -->
            <div class="mb-10 bg-gray-750 p-6 rounded-lg border border-gray-600">
                <h2 class="text-xl font-semibold text-blue-400 mb-4 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z" />
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 6.833 6 8c0 1.167.602 1.766 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 13.167 14 12c0-1.167-.602-1.766-1.324-2.246-.48-.32-1.054-.545-1.676-.662V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd" />
                    </svg>
                    Pricing Information
                </h2>
                <form action="/instructor/updateprice/{{ $instructor->id }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @csrf
                    <div>
                        <label for="hourly_rate" class="block text-sm font-medium text-gray-300 mb-1">Hourly Rate (₱)</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-400">₱</span>
                            </div>
                            <input type="text" id="hourly_rate" name="hourly_rate" value="{{ old('hourly_rate', $instructor->hourly_rate) }}" 
                                class="pl-8 w-full bg-gray-800 text-gray-100 p-3 rounded-md border border-gray-600 focus:border-blue-400 focus:ring focus:ring-blue-400 focus:ring-opacity-50" required>
                        </div>
                        @error('hourly_rate')
                            <span class="text-red-400 text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="monthly_rate" class="block text-sm font-medium text-gray-300 mb-1">Monthly Rate (₱)</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-400">₱</span>
                            </div>
                            <input type="text" id="monthly_rate" name="monthly_rate" value="{{ old('monthly_rate', $instructor->monthly_rate) }}" 
                                class="pl-8 w-full bg-gray-800 text-gray-100 p-3 rounded-md border border-gray-600 focus:border-blue-400 focus:ring focus:ring-blue-400 focus:ring-opacity-50" required>
                        </div>
                        @error('monthly_rate')
                            <span class="text-red-400 text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="md:col-span-2 flex justify-end">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-md font-medium transition duration-200 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd" />
                            </svg>
                            Update Rates
                        </button>
                    </div>
                </form>
            </div>

            <!-- Profile Section -->
            <div class="bg-gray-750 p-6 rounded-lg border border-gray-600">
                <h2 class="text-xl font-semibold text-blue-400 mb-6 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                    </svg>
                    Personal Information
                </h2>
                
                <div class="flex flex-col md:flex-row gap-8">
                    <div class="flex-shrink-0 flex flex-col items-center space-y-3">
                        <div class="relative group">
                            <img src="{{ asset('storage/' . $instructor->profile_image) }}" alt="Profile Picture" 
                                class="w-48 h-48 rounded-full border-4 border-blue-500 object-cover shadow-lg">
                            <div class="absolute inset-0 rounded-full bg-black bg-opacity-50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                <span class="text-white text-sm">Change Photo</span>
                            </div>
                        </div>
                        <p class="text-gray-400 text-sm text-center">Click on photo to update</p>
                    </div>

                    <div class="flex-grow">
                        <form action="/instructor/updateprofile/{{ $instructor->id }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div>
                                    <label for="first_name" class="block text-sm font-medium text-gray-300 mb-1">First Name</label>
                                    <input type="text" id="first_name" name="first_name" value="{{ $instructor->first_name }}" 
                                        class="w-full bg-gray-800 text-gray-100 p-3 rounded-md border border-gray-600 focus:border-blue-400 focus:ring focus:ring-blue-400 focus:ring-opacity-50" required>
                                </div>
                                <div>
                                    <label for="middle_name" class="block text-sm font-medium text-gray-300 mb-1">Middle Name</label>
                                    <input type="text" id="middle_name" name="middle_name" value="{{ $instructor->middle_name }}" 
                                        class="w-full bg-gray-800 text-gray-100 p-3 rounded-md border border-gray-600 focus:border-blue-400 focus:ring focus:ring-blue-400 focus:ring-opacity-50">
                                </div>
                            </div>

                            <div>
                                <label for="last_name" class="block text-sm font-medium text-gray-300 mb-1">Last Name</label>
                                <input type="text" id="last_name" name="last_name" value="{{ $instructor->last_name }}" 
                                    class="w-full bg-gray-800 text-gray-100 p-3 rounded-md border border-gray-600 focus:border-blue-400 focus:ring focus:ring-blue-400 focus:ring-opacity-50" required>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-300 mb-1">Email Address</label>
                                    <input type="email" id="email" name="email" value="{{ $instructor->email }}" 
                                        class="w-full bg-gray-800 text-gray-100 p-3 rounded-md border border-gray-600 focus:border-blue-400 focus:ring focus:ring-blue-400 focus:ring-opacity-50" required>
                                </div>
                                <div>
                                    <label for="phone_number" class="block text-sm font-medium text-gray-300 mb-1">Phone Number</label>
                                    <input type="text" id="phone_number" name="phone_number" value="{{ $instructor->phone_number }}" 
                                        class="w-full bg-gray-800 text-gray-100 p-3 rounded-md border border-gray-600 focus:border-blue-400 focus:ring focus:ring-blue-400 focus:ring-opacity-50" required>
                                </div>
                            </div>

                            <div>
                                <label for="bio" class="block text-sm font-medium text-gray-300 mb-1">Professional Biography</label>
                                <textarea id="bio" name="bio" rows="5" 
                                    class="w-full bg-gray-800 text-gray-100 p-3 rounded-md border border-gray-600 focus:border-blue-400 focus:ring focus:ring-blue-400 focus:ring-opacity-50" required>{{ $instructor->bio }}</textarea>
                                <p class="text-gray-400 text-xs mt-1">Write a compelling bio that highlights your experience and expertise</p>
                            </div>

                            <div class="hidden">
                                <input type="file" id="profile_image" name="profile_image" 
                                    class="w-full bg-gray-800 text-gray-100 p-3 rounded-md border border-gray-600">
                            </div>

                            <div class="flex justify-end">
                                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-md font-medium transition duration-200 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M7.707 10.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V6h5a2 2 0 012 2v7a2 2 0 01-2 2H4a2 2 0 01-2-2V8a2 2 0 012-2h5v5.586l-1.293-1.293zM9 4a1 1 0 012 0v2H9V4z" />
                                    </svg>
                                    Save Changes
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        document.querySelector('.relative.group').addEventListener('click', function() {
            document.getElementById('profile_image').click();
        });
        
        document.getElementById('profile_image').addEventListener('change', function() {
            if (this.files && this.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    document.querySelector('.relative.group img').src = e.target.result;
                };
                reader.readAsDataURL(this.files[0]);
            }
        });
    </script>
</body>
</html>
