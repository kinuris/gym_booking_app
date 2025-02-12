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
    <div class="container mx-auto px-4 mt-8">
        <div class="flex justify-center">
            <div class="w-full">
                <div class="bg-gray-800 shadow-md rounded-lg">
                    <div class="flex justify-between items-center px-6 py-4 border-b border-gray-700">
                        <h5 class="text-xl font-semibold text-white">Manage Featured Instructors</h5>
                        <button type="button" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md" data-bs-toggle="modal" data-bs-target="#addStoryModal">
                            Add Instructor
                        </button>
                    </div>

                    <div class="p-6">
                        <table class="min-w-full divide-y divide-gray-700">
                            <thead>
                                <tr class="bg-gray-700">
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Profile Picture</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Stars</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-gray-800 divide-y divide-gray-700">
                                @foreach ($instructors as $instructor)
                                <tr>
                                    <td class="px-6 py-4">
                                        <img src="{{ asset('storage/' . $instructor->profile_image) }}" alt="{{ $instructor->name }}" class="h-12 w-12 rounded-full">
                                    </td>
                                    <td class="px-6 py-4">{{ $instructor->fullname }}</td>
                                    <td class="px-6 py-4">{{ $instructor->stars }} / 5</td>
                                    <td class="px-6 py-4">
                                        <form action="/admin/featured-instructor/{{ $instructor->id }}/delete" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded-md">Remove</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
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