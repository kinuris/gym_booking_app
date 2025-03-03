@if (session('message'))
    <div class="fixed bottom-0 w-full bg-gray-800 text-white text-center py-3 px-4 z-50 animate-fadeIn">
        <div class="flex items-center justify-center">
            <span>{{ session('message') }}</span>
            <button class="ml-4 focus:outline-none" onclick="this.parentElement.parentElement.style.display='none'">
                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
            </button>
        </div>
    </div>
@endif

<nav class="bg-gradient-to-r from-gray-900 to-gray-800 shadow-xl">
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <img src="{{ asset('assets/logo.jpg') }}" alt="Logo" class="h-10 w-auto rounded-lg shadow">
                </div>
                <div class="hidden md:block ml-10">
                    <div class="flex items-baseline space-x-4">
                        <a href="/client" class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium transition duration-200 ease-in-out">
                            Profile
                        </a>
                        <a href="/my/sessions" class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium transition duration-200 ease-in-out">
                            My Sessions
                        </a>
                        <a href="/client/browse" class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium transition duration-200 ease-in-out">
                            Browse Instructors
                        </a>
                        <a href="/logout" class="ml-4 bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded-md text-sm font-medium transition duration-200 ease-in-out">
                            Logout
                        </a>
                    </div>
                </div>
            </div>
            <div class="md:hidden flex items-center">
                <button type="button" class="text-gray-300 hover:text-white focus:outline-none">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</nav>