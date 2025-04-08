<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Profile</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-900 text-gray-100 min-h-screen">
    @if($notifications->isNotEmpty())
    <div class="fixed top-16 right-5 w-80 max-h-[70vh] bg-gray-800 rounded-lg shadow-xl overflow-hidden border border-gray-700 transition-all duration-300 z-50">
        <div class="flex justify-between items-center bg-gray-700 px-4 py-3 border-b border-gray-600">
            <h2 class="text-blue-400 font-semibold flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
                Notifications ({{ $notifications->count() }})
            </h2>
            <button onclick="this.closest('.fixed').classList.add('opacity-0');setTimeout(() => this.closest('.fixed').style.display='none', 300);" 
                    class="text-gray-400 hover:text-white hover:bg-gray-600 rounded-full p-1 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </button>
        </div>
        <div class="overflow-y-auto max-h-[60vh] custom-scrollbar p-3">
            <ul class="space-y-3">
                @foreach($notifications as $notification)
                <li class="bg-gray-700 rounded-md p-3 hover:bg-gray-650 transition-colors shadow-sm">
                    <strong class="text-blue-400 text-sm">{{ $notification->title }}</strong>
                    <p class="text-gray-300 mt-1 text-sm">{{ $notification->body }}</p>
                    <div class="flex justify-between items-center mt-2">
                        <span class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}</span>
                        @if(!$notification->read)
                            <span class="bg-blue-500 rounded-full h-2 w-2"></span>
                        @endif
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #2d3748;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background-color: #4a5568;
            border-radius: 3px;
        }
    </style>
    @endif

    @include('client.nav')
    <div class="max-w-4xl mx-auto mt-12 p-8 bg-gray-800 rounded-lg shadow-2xl">
        <h2 class="text-3xl font-bold text-center mb-8 text-blue-400">Your Profile</h2>
        
        @if(session('success'))
            <div class="bg-green-500 text-white p-4 rounded-lg mb-6">
                {{ session('success') }}
            </div>
        @endif

        <form action="/client/updateprofile/{{ $client->id }}" method="POST" class="space-y-8" enctype="multipart/form-data">
            @csrf
            <div class="flex flex-col sm:flex-row items-center gap-8">
                <div class="relative group">
                    <div class="w-36 h-36 rounded-full overflow-hidden ring-4 ring-blue-500 shadow-lg">
                        <img src="{{ asset('storage/' . $client->profile_image) }}" alt="Profile Image"
                            class="w-full h-full object-cover" id="profileImage">
                    </div>
                    <div class="absolute inset-0 bg-black bg-opacity-50 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer">
                        <span class="text-white text-sm">Change Photo</span>
                    </div>
                    <input type="file" class="absolute inset-0 opacity-0 cursor-pointer" id="profileImageInput"
                        accept="image/*" name="profile_image" onchange="loadFile(event)">
                </div>
                
                <div class="flex-1">
                    <h3 class="text-xl font-semibold text-blue-300 mb-2">{{ $client->first_name }} {{ $client->last_name }}</h3>
                    <p class="text-gray-400 mb-4">Member since {{ \Carbon\Carbon::parse($client->created_at)->format('F Y') }}</p>
                    @error('profile_image')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="bg-gray-700 p-6 rounded-lg shadow-inner">
                <h3 class="text-xl font-semibold mb-4 border-b border-gray-600 pb-2">Personal Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="firstName" class="block text-sm font-medium mb-2 text-gray-300">First Name</label>
                        <input type="text" value="{{ $client->first_name }}"
                            class="w-full px-4 py-3 bg-gray-800 border border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('first_name') border-red-500 @enderror"
                            id="firstName" name="first_name">
                        @error('first_name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="middleName" class="block text-sm font-medium mb-2 text-gray-300">Middle Name</label>
                        <input type="text" value="{{ $client->middle_name }}"
                            class="w-full px-4 py-3 bg-gray-800 border border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('middle_name') border-red-500 @enderror"
                            id="middleName" name="middle_name">
                        @error('middle_name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="lastName" class="block text-sm font-medium mb-2 text-gray-300">Last Name</label>
                        <input type="text" value="{{ $client->last_name }}"
                            class="w-full px-4 py-3 bg-gray-800 border border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('last_name') border-red-500 @enderror"
                            id="lastName" name="last_name">
                        @error('last_name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="phoneNumber" class="block text-sm font-medium mb-2 text-gray-300">Phone Number</label>
                        <input type="text" value="{{ $client->phone_number }}"
                            class="w-full px-4 py-3 bg-gray-800 border border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('phone_number') border-red-500 @enderror"
                            id="phoneNumber" name="phone_number">
                        @error('phone_number')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium mb-2 text-gray-300">Email Address</label>
                        <input type="email" value="{{ $client->email }}"
                            class="w-full px-4 py-3 bg-gray-800 border border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('email') border-red-500 @enderror"
                            id="email" name="email">
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="gender" class="block text-sm font-medium mb-2 text-gray-300">Gender</label>
                        <select class="w-full px-4 py-3 bg-gray-800 border border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('gender') border-red-500 @enderror"
                            id="gender" name="gender">
                            <option value="male" {{ $client->gender == 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ $client->gender == 'female' ? 'selected' : '' }}>Female</option>
                            <option value="other" {{ $client->gender == 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('gender')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="birthdate" class="block text-sm font-medium mb-2 text-gray-300">Birthdate</label>
                        <input type="date" value="{{ $client->birthdate }}"
                            class="w-full px-4 py-3 bg-gray-800 border border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('birthdate') border-red-500 @enderror"
                            id="birthdate" name="birthdate">
                        @error('birthdate')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="text-center mt-10">
                <button type="submit"
                    class="px-8 py-3 bg-blue-600 hover:bg-blue-700 rounded-lg font-semibold transition-all duration-300 shadow-lg hover:shadow-blue-500/30">
                    Save Changes
                </button>
            </div>
        </form>
    </div>

    <script>
        function loadFile(event) {
            var image = document.getElementById('profileImage');
            image.src = URL.createObjectURL(event.target.files[0]);
        }
    </script>
</body>

</html>