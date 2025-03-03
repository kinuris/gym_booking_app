<!DOCTYPE html>
<html lang="en" class="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>Manage Accounts</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body class="bg-gray-900 text-white font-sans">
    @include('admin.nav')

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-white mb-6">Manage Instructors</h1>
            
            <form action="" method="GET" class="flex flex-col sm:flex-row gap-4">
                <div class="relative flex-grow">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input type="text" name="query" placeholder="Search instructors..." class="w-full pl-10 pr-4 py-3 rounded-lg bg-gray-800 text-white border border-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                <button type="submit" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-500/50 text-white font-medium rounded-lg transition duration-150 ease-in-out flex items-center justify-center">
                    Search
                </button>
            </form>
        </div>

        <div class="bg-gray-800 rounded-lg shadow-xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-700">
                    <thead>
                        <tr>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">ID</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Profile</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Name</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Email</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Phone</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700">
                        @foreach($instructors as $instructor)
                        <tr class="hover:bg-gray-700 transition duration-150">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-200">{{ $instructor->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <img src="{{ asset('storage/' . $instructor->profile_image) }}" alt="Profile Image" class="h-10 w-10 rounded-full object-cover border border-gray-600">
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-white">{{ $instructor->fullname }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-200">{{ $instructor->email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-200">{{ $instructor->phone_number }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @if($instructor->is_disabled)
                                    <a href="/instructor/enable/{{ $instructor->id }}" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition">
                                        Enable Account
                                    </a>
                                @else
                                    <a href="/instructor/disable/{{ $instructor->id }}" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition">
                                        Disable Account
                                    </a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>