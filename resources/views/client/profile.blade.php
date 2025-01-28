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
    <div class="fixed top-16 right-5 w-72 max-h-96 bg-gray-800 rounded-lg shadow-lg p-4">
        <button onclick="this.parentElement.style.display='none';" class="absolute top-2 right-2 text-gray-400 hover:text-white">
            &times;
        </button>
        <h2 class="text-blue-400 text-lg font-semibold mb-3">Notifications</h2>
        <ul class="space-y-3">
            @foreach($notifications as $notification)
            <li class="bg-gray-700 rounded-md p-3">
                <strong class="text-blue-400">{{ $notification->title }}</strong>
                <p class="text-gray-300 mt-1">{{ $notification->body }}</p>
                <p class="text-xs text-gray-400 text-right mt-2">{{ $notification->created_at }}</p>
            </li>
            @endforeach
        </ul>
    </div>
    @endif

    @include('client.nav')

    <div class="max-w-2xl mx-auto mt-12 p-6 bg-gray-800 rounded-lg shadow-xl">
        <h2 class="text-2xl font-bold text-center mb-8">Client Profile</h2>

        <form action="/client/updateprofile/{{ $client->id }}" method="POST" class="space-y-6" enctype="multipart/form-data">
            @csrf
            <div class="text-center">
                <div class="relative w-32 h-32 mx-auto mb-4">
                    <img src="{{ asset('storage/' . $client->profile_image) }}" alt="Profile Image"
                        class="w-full h-full rounded-full object-cover" id="profileImage">
                </div>
                <input type="file"
                    class="w-full px-3 py-2 bg-gray-700 rounded-lg focus:ring-2 focus:ring-blue-500 @error('profile_image') border-red-500 @enderror"
                    id="profileImageInput"
                    accept="image/*"
                    name="profile_image"
                    onchange="loadFile(event)">
                @error('profile_image')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="firstName" class="block text-sm font-medium mb-2">First Name</label>
                    <input type="text" value="{{ $client->first_name }}"
                        class="w-full px-3 py-2 bg-gray-700 rounded-lg focus:ring-2 focus:ring-blue-500 @error('first_name') border-red-500 @enderror"
                        id="firstName" name="first_name">
                    @error('first_name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="middleName" class="block text-sm font-medium mb-2">Middle Name</label>
                    <input type="text" value="{{ $client->middle_name }}"
                        class="w-full px-3 py-2 bg-gray-700 rounded-lg focus:ring-2 focus:ring-blue-500 @error('middle_name') border-red-500 @enderror"
                        id="middleName" name="middle_name">
                    @error('middle_name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="lastName" class="block text-sm font-medium mb-2">Last Name</label>
                    <input type="text" value="{{ $client->last_name }}"
                        class="w-full px-3 py-2 bg-gray-700 rounded-lg focus:ring-2 focus:ring-blue-500 @error('last_name') border-red-500 @enderror"
                        id="lastName" name="last_name">
                    @error('last_name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="phoneNumber" class="block text-sm font-medium mb-2">Phone Number</label>
                    <input type="text" value="{{ $client->phone_number }}"
                        class="w-full px-3 py-2 bg-gray-700 rounded-lg focus:ring-2 focus:ring-blue-500 @error('phone_number') border-red-500 @enderror"
                        id="phoneNumber" name="phone_number">
                    @error('phone_number')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium mb-2">Email</label>
                    <input type="email" value="{{ $client->email }}"
                        class="w-full px-3 py-2 bg-gray-700 rounded-lg focus:ring-2 focus:ring-blue-500 @error('email') border-red-500 @enderror"
                        id="email" name="email">
                    @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="gender" class="block text-sm font-medium mb-2">Gender</label>
                    <select class="w-full px-3 py-2 bg-gray-700 rounded-lg focus:ring-2 focus:ring-blue-500 @error('gender') border-red-500 @enderror"
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
                    <label for="birthdate" class="block text-sm font-medium mb-2">Birthdate</label>
                    <input type="date" value="{{ $client->birthdate }}"
                        class="w-full px-3 py-2 bg-gray-700 rounded-lg focus:ring-2 focus:ring-blue-500 @error('birthdate') border-red-500 @enderror"
                        id="birthdate" name="birthdate">
                    @error('birthdate')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="text-center mt-8">
                <button type="submit"
                    class="px-6 py-3 bg-blue-600 hover:bg-blue-700 rounded-lg font-medium transition-colors duration-200">
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