<!DOCTYPE html>
<html lang="en" class="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>Manage Stories</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body class="bg-gray-900 text-white">
    @include('admin.nav')
    <div class="container mx-auto px-4 mt-8">
        <div class="flex justify-center">
            <div class="w-full">
                <div class="bg-gray-800 shadow-md rounded-lg">
                    <div class="flex justify-between items-center px-6 py-4 border-b border-gray-700">
                        <h5 class="text-xl font-semibold text-white">Manage Homepage Stories</h5>
                        <button type="button" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md" data-bs-toggle="modal" data-bs-target="#addStoryModal">
                            Add New Story
                        </button>
                    </div>

                    <div class="p-6">
                        <table class="min-w-full divide-y divide-gray-700">
                            <thead>
                                <tr class="bg-gray-700">
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Title</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Content</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-gray-800 divide-y divide-gray-700">
                                @foreach($stories as $story)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-200">{{ $story->title }}</td>
                                    <td class="px-6 py-4 text-gray-200 text-sm italic">{{ Str::limit($story->body, 100) }}</td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-1 text-sm rounded-full {{ $story->status === 'active' ? 'bg-green-900 text-green-300' : 'bg-red-900 text-red-300' }}">
                                            {{ $story->status === 'active' ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 space-x-2 flex">
                                        <a href="?edit_story={{ $story->id }}" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm flex place-items-center">Edit</a>
                                        <a href="/admin/homepage-story/{{ $story->id }}/toggle-status" class="bg-yellow-600 hover:bg-yellow-700 text-white flex place-items-center px-3 py-1.5 rounded text-sm">
                                            {{ $story->status === 'active' ? 'Disable' : 'Enable' }}
                                        </a>
                                        <form action="/admin/homepage-story/{{ $story->id }}/delete" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1.5 rounded text-sm flex place-items-center" onclick="return confirm('Are you sure?')">Delete</button>
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

    @php ($story = request('edit_story'))
    @if ($story)
    @php ($story = App\Models\HomeClientStory::find($story)) 
    <!-- Edit Story Modal -->
    <div id="editStoryModal" class="fixed top-0 inset-0 bg-black bg-opacity-60 backdrop-blur-sm overflow-y-auto h-full w-full z-50">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="relative bg-gray-800 rounded-xl shadow-2xl w-full max-w-[700px] mx-auto scale-95">
                <div class="flex justify-between items-center p-6 border-b border-gray-700">
                    <h5 class="text-xl font-bold text-white">Edit Story</h5>
                    <button type="button" class="text-gray-400 hover:text-gray-200" onclick="window.location.href='/admin/homepage-story'">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <form action="/admin/homepage-story/{{ $story->id }}/update" method="POST" enctype="multipart/form-data" class="divide-y divide-gray-700">
                    @csrf
                    @method('PUT')
                    <div class="p-8 space-y-6">
                        <div class="grid grid-cols-1 gap-6">
                            <div>
                                <label for="edit_title" class="block text-sm font-semibold text-gray-300 mb-1">Story Title</label>
                                <input type="text" class="w-full px-4 py-2 rounded-lg border border-gray-600 bg-gray-700 text-white" 
                                    id="edit_title" name="title" value="{{ $story->title }}" required>
                            </div>
                            <div>
                                <label for="edit_subtitle" class="block text-sm font-semibold text-gray-300 mb-1">Story Subtitle</label>
                                <input type="text" class="w-full px-4 py-2 rounded-lg border border-gray-600 bg-gray-700 text-white"
                                    id="edit_subtitle" name="subtitle" value="{{ $story->subtitle }}" required>
                            </div>
                            <div>
                                <label for="edit_content" class="block text-sm font-semibold text-gray-300 mb-1">Content</label>
                                <textarea class="w-full px-4 py-2 rounded-lg border border-gray-600 bg-gray-700 text-white"
                                    id="edit_content" name="content" rows="4" required>{{ $story->body }}</textarea>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-300 mb-1">Primary Image</label>
                                    <input type="file" class="w-full text-sm text-gray-300 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-gray-600 file:text-gray-200"
                                        name="image_link_1" accept="image/*" onchange="previewImage(this, 'edit_preview1')">
                                    <div id="edit_preview1" class="mt-2 h-40 bg-gray-700 rounded-lg border-2 border-dashed border-gray-600">
                                        @if($story->image_link_1)
                                            <img src="{{ asset('storage/' . $story->image_link_1) }}" class="h-full w-full object-contain">
                                        @endif
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-300 mb-1">Secondary Image</label>
                                    <input type="file" class="w-full text-sm text-gray-300 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-gray-600 file:text-gray-200"
                                        name="image_link_2" accept="image/*" onchange="previewImage(this, 'edit_preview2')">
                                    <div id="edit_preview2" class="mt-2 h-40 bg-gray-700 rounded-lg border-2 border-dashed border-gray-600">
                                        @if($story->image_link_2)
                                            <img src="{{ asset('storage/' . $story->image_link_2) }}" class="h-full w-full object-contain">
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="px-8 py-6 bg-gray-900 rounded-b-xl flex justify-end space-x-3">
                        <a href="/admin/homepage-story" class="px-5 py-2.5 text-sm font-medium text-gray-300 bg-gray-700 rounded-lg hover:bg-gray-600">Cancel</a>
                        <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700">Update Story</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif

    <!-- Add Story Modal -->
    <div id="addStoryModal" class="hidden fixed top-0 inset-0 bg-black bg-opacity-60 backdrop-blur-sm overflow-y-auto h-full w-full z-50 transition-opacity duration-300">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="relative bg-gray-800 rounded-xl shadow-2xl w-full max-w-[700px] mx-auto transform transition-all duration-300 scale-95"
                id="modalContent">
                <div class="flex justify-between items-center p-6 border-b border-gray-700">
                    <h5 class="text-xl font-bold text-white">Add New Story</h5>
                    <button type="button" class="text-gray-400 hover:text-gray-200 transition-colors duration-200"
                        onclick="closeModal('addStoryModal')">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                @if ($errors->any())
                <div class="p-4 bg-red-900 text-red-200 rounded-lg mx-6 my-2">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <form action="/admin/homepage-story/create" method="POST" enctype="multipart/form-data" class="divide-y divide-gray-700">
                    @csrf
                    <div class="p-8 space-y-6">
                        <div class="grid grid-cols-1 gap-6">
                            <div>
                                <label for="title" class="block text-sm font-semibold text-gray-300 mb-1">Story Title</label>
                                <input type="text" class="w-full px-4 py-2 rounded-lg border border-gray-600 bg-gray-700 text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 @error('title') border-red-500 @enderror"
                                    id="title" name="title" placeholder="Enter story title" required value="{{ old('title') }}">
                                @error('title')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="subtitle" class="block text-sm font-semibold text-gray-300 mb-1">Story Subtitle</label>
                                <input type="text" class="w-full px-4 py-2 rounded-lg border border-gray-600 bg-gray-700 text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 @error('subtitle') border-red-500 @enderror"
                                    id="subtitle" name="subtitle" placeholder="Enter story subtitle" required value="{{ old('subtitle') }}">
                                @error('subtitle')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="content" class="block text-sm font-semibold text-gray-300 mb-1">Content</label>
                                <textarea class="w-full px-4 py-2 rounded-lg border border-gray-600 bg-gray-700 text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 @error('content') border-red-500 @enderror"
                                    id="content" name="content" rows="4" placeholder="Enter story content" required>{{ old('content') }}</textarea>
                                @error('content')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="image1" class="block text-sm font-semibold text-gray-300 mb-1">Primary Image</label>
                                    <input type="file" class="w-full text-sm text-gray-300 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-gray-600 file:text-gray-200 hover:file:bg-gray-700 transition-colors duration-200 @error('image_link_1') border-red-500 @enderror"
                                        id="image1" name="image_link_1" accept="image/*" onchange="previewImage(this, 'preview1')">

                                    <div id="preview1" class="mt-2 h-40 bg-gray-700 rounded-lg border-2 border-dashed border-gray-600 flex items-center justify-center">
                                        <span class="text-gray-400">Image preview</span>
                                    </div>
                                    @error('image_link_1')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="image2" class="block text-sm font-semibold text-gray-300 mb-1">Secondary Image</label>
                                    <input type="file" class="w-full text-sm text-gray-300 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-gray-600 file:text-gray-200 hover:file:bg-gray-700 transition-colors duration-200 @error('image_link_2') border-red-500 @enderror"
                                        id="image2" name="image_link_2" accept="image/*" onchange="previewImage(this, 'preview2')">

                                    <div id="preview2" class="mt-2 h-40 bg-gray-700 rounded-lg border-2 border-dashed border-gray-600 flex items-center justify-center">
                                        <span class="text-gray-400">Image preview</span>
                                    </div>
                                    @error('image_link_2')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            {{--<div>
                                <label for="status" class="block text-sm font-semibold text-gray-300 mb-1">Status</label>
                                <select class="w-full px-4 py-2 rounded-lg border border-gray-600 bg-gray-700 text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                                    id="status" name="status">
                                    <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>--}}
                        </div>
                    </div>
                    <div class="px-8 py-6 bg-gray-900 rounded-b-xl flex items-center justify-end space-x-3">
                        <button type="button"
                            class="px-5 py-2.5 text-sm font-medium text-gray-300 bg-gray-700 border border-gray-600 rounded-lg hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 transition-colors duration-200"
                            onclick="closeModal('addStoryModal')">Cancel</button>
                        <button type="submit"
                            class="px-5 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-200">Save Story</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function previewImage(input, previewId) {
            const preview = document.getElementById(previewId);
            preview.innerHTML = '';

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'h-full w-full object-contain';
                    preview.appendChild(img);
                }

                reader.readAsDataURL(input.files[0]);
            } else {
                preview.innerHTML = '<span class="text-gray-400">Image preview will appear here</span>';
            }
        }
    </script>

    <script>
        <?php if (session('openModal') === 1): ?>
            document.addEventListener('DOMContentLoaded', function() {
                openModal('addStoryModal');
            });
        <?php endif ?>
    </script>

    <script>
        function openModal(modalId) {
            document.getElementById(modalId).classList.remove('hidden');
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }

        // Update the button click handler
        document.querySelector('[data-bs-toggle="modal"]').addEventListener('click', function() {
            openModal('addStoryModal');
        });
    </script>

</body>

</html>