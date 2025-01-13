<!DOCTYPE html>
<html lang="en" class="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>Manage Accounts</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body class="bg-gray-900 text-white">
    @include('admin.nav')
    <div class="container mx-auto p-4 mt-4">
        <form action="" method="GET" class="mb-4">
            <input type="text" name="search" placeholder="Search clients..." class="w-full p-2 rounded bg-gray-800 text-white border border-gray-700">
            <button type="submit" class="mt-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Search</button>
        </form>
    </div>

    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold mb-4">Manage Clients</h1>
        <table class="min-w-full bg-gray-800 text-white">
            <thead>
                <tr class="text-left">
                    <th class="py-2 px-4 border-b border-gray-700">ID</th>
                    <th class="py-2 px-4 border-b border-gray-700">Profile Image</th>
                    <th class="py-2 px-4 border-b border-gray-700">Name</th>
                    <th class="py-2 px-4 border-b border-gray-700">Email</th>
                    <th class="py-2 px-4 border-b border-gray-700">Phone Number</th>
                    <th class="py-2 px-4 border-b border-gray-700">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($clients as $client)
                <tr class="bg-gray-700 hover:bg-gray-600">
                    <td class="py-2 px-4 border-b border-gray-700">{{ $client->id }}</td>
                    <td class="py-2 px-4 border-b border-gray-700">
                        <img src="{{ asset('storage/' . $client->profile_image) }}" alt="Profile Image" class="w-12 h-12 object-cover rounded-full">
                    </td>
                    <td class="py-2 px-4 border-b border-gray-700">{{ $client->fullname }}</td>
                    <td class="py-2 px-4 border-b border-gray-700">{{ $client->email }}</td>
                    <td class="py-2 px-4 border-b border-gray-700">{{ $client->phone_number }}</td>
                    <td class="py-2 px-4 border-b border-gray-700">
                        @if($client->is_disabled)
                            <a href="/client/enable/{{ $client->id }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded">Enable</a>
                        @else
                            <a href="/client/disable/{{ $client->id }}" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded">Disable</a>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>