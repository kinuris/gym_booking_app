<nav class="bg-gradient-to-r from-gray-900 to-gray-800 shadow-lg">
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex justify-between h-16">
            <div class="flex items-center space-x-1 md:space-x-4">
                <div class="flex-shrink-0 flex items-center">
                    <img src="{{ asset('assets/logo.jpg') }}" alt="Logo" class="h-10 w-auto rounded-md shadow">
                </div>
                <div class="hidden md:flex md:space-x-2">
                    <a href="/instructor" class="inline-flex items-center px-4 py-2 text-sm font-medium {{ request()->is('instructor') ? 'text-white bg-gray-700' : 'text-gray-300 hover:text-white hover:bg-gray-700' }} rounded-md transition duration-150 ease-in-out">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Profile
                    </a>
                    <a href="/instructor/clients" class="inline-flex items-center px-4 py-2 text-sm font-medium {{ request()->is('instructor/clients') ? 'text-white bg-gray-700' : 'text-gray-300 hover:text-white hover:bg-gray-700' }} rounded-md transition duration-150 ease-in-out">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        Clients
                    </a>
                </div>
            </div>
            <div class="flex items-center">
                <a href="/logout" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-300 hover:text-white hover:bg-red-700 rounded-md transition duration-150 ease-in-out">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    Logout
                </a>
            </div>
        </div>
    </div>
</nav>