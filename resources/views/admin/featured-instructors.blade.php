<!DOCTYPE html>
<html lang="en" class="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>Manage Featured Instructors</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body class="bg-gray-900 text-white">
    @include('admin.nav')
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-6xl mx-auto">
            <div class="bg-gray-800 shadow-lg rounded-lg overflow-hidden">
                <div class="flex justify-between items-center px-6 py-5 border-b border-gray-700">
                    <h2 class="text-2xl font-bold text-white">Featured Instructors</h2>
                    <button type="button" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md transition duration-200 flex items-center" data-bs-toggle="modal" data-bs-target="#addStoryModal">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        Add Instructor
                    </button>
                </div>

                <div class="p-6">
                    @if(count($instructors) > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-700">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Profile</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Instructor Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Rating</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-gray-800 divide-y divide-gray-700">
                                @foreach ($instructors as $instructor)
                                <tr class="hover:bg-gray-750 transition duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <img src="{{ asset('storage/' . $instructor->profile_image) }}" alt="{{ $instructor->fullname }}" class="h-12 w-12 rounded-full object-cover border-2 border-gray-600">
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-white">{{ $instructor->fullname }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <span class="text-yellow-400 mr-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                </svg>
                                            </span>
                                            <span class="text-white">{{ number_format($instructor->stars, 1) }} / 5</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <form action="/admin/featured-instructor/{{ $instructor->id }}/delete" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md transition duration-200" onclick="return confirm('Are you sure you want to remove this instructor?')">
                                                Remove
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-center py-8">
                        <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                        </svg>
                        <h3 class="mt-2 text-lg font-medium text-gray-200">No featured instructors</h3>
                        <p class="mt-1 text-sm text-gray-400">Get started by adding a featured instructor.</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Add Instructor Modal -->
    <div id="addStoryModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center">
        <div class="bg-gray-800 p-8 rounded-lg w-96">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold">Add Featured Instructor</h3>
                <button class="text-gray-400 hover:text-white" onclick="closeModal()">×</button>
            </div>

            <form action="/admin/featured-instructor/create" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label for="instructor_id" class="block text-gray-300 mb-2">Select Instructor</label>
                    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
                    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>

                    <select name="instructor_id" id="instructor_id" class="w-full bg-gray-700 text-white rounded px-3 py-2" required>
                        <option value="">Select an instructor</option>
                        @foreach(\App\Models\Instructor::all() as $instructor)
                        @unless(\App\Models\FeaturedInstructor::where('instructor_id', $instructor->id)->exists())
                        <option value="{{ $instructor->id }}">{{ $instructor->fullname }}</option>
                        @endunless
                        @endforeach
                    </select>

                    <script>
                        new TomSelect('#instructor_id', {
                            searchField: 'text',
                            maxItems: 1,
                            create: false,
                            dropdownParent: 'body'
                        });
                    </script>
                </div>

                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded">
                    Add Instructor
                </button>
            </form>
        </div>
    </div>

    <script>
        function closeModal() {
            document.getElementById('addStoryModal').classList.add('hidden');
        }

        document.querySelector('[data-bs-target="#addStoryModal"]').addEventListener('click', function() {
            document.getElementById('addStoryModal').classList.remove('hidden');
            document.getElementById('addStoryModal').classList.add('flex');
        });
    </script>
</body>

</html>