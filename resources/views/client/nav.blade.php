@if (session('message'))
    <div class="fixed bottom-0 w-full bg-gray-800 text-white text-center py-3 px-4">
        {{ session('message') }}
    </div>
@endif

<nav class="bg-gray-800 shadow-lg">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex justify-between h-16">
            <div class="flex space-x-8 items-center">
                <img src="{{ asset('assets/logo.jpg') }}" alt="Logo" class="h-10 w-auto rounded">
                <ul class="flex items-center space-x-4">
                    <li>
                        <a href="/client" class="text-white hover:text-gray-300 px-3 py-2 rounded-md text-sm font-medium transition duration-150 ease-in-out">
                            Profile
                        </a>
                    </li>
                    <li>
                        <a href="/my/sessions" class="text-white hover:text-gray-300 px-3 py-2 rounded-md text-sm font-medium transition duration-150 ease-in-out">
                            My Sessions
                        </a>
                    </li>
                    <li>
                        <a href="/client/browse" class="text-white hover:text-gray-300 px-3 py-2 rounded-md text-sm font-medium transition duration-150 ease-in-out">
                            Browse Instructors
                        </a>
                    </li>
                    <li>
                        <a href="/logout" class="text-white hover:text-gray-300 px-3 py-2 rounded-md text-sm font-medium transition duration-150 ease-in-out">
                            Logout
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>