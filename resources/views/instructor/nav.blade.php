<nav class="bg-gray-800 shadow-lg">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex justify-between h-16">
            <div class="flex space-x-8 items-center">
                <img src="{{ asset('assets/logo.jpg') }}" alt="Logo" class="h-10 w-auto rounded">
                <a href="/instructor" class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-300 hover:text-white hover:bg-gray-700 rounded-md transition duration-150 ease-in-out">
                    Profile
                </a>
                <a href="/instructor/clients" class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-300 hover:text-white hover:bg-gray-700 rounded-md transition duration-150 ease-in-out">
                    Clients
                </a>
                <a href="/logout" class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-300 hover:text-white hover:bg-gray-700 rounded-md transition duration-150 ease-in-out">
                    Logout
                </a>
            </div>
        </div>
    </div>
</nav>