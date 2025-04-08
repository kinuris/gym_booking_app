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
    <div class="container mx-auto px-6 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-white flex items-center">
                <svg class="w-6 h-6 mr-2 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                </svg>
                Homepage Stories Management
            </h1>
            <button type="button" class="px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow-lg transition-all flex items-center font-medium" data-bs-toggle="modal" data-bs-target="#addStoryModal">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path>
                </svg>
                Add New Story
            </button>
        </div>

        <div class="bg-gray-800 rounded-xl border border-gray-700 shadow-xl overflow-hidden">
            <div class="border-b border-gray-700 bg-gray-750 px-6 py-4">
                <h2 class="font-semibold text-lg text-white">All Stories</h2>
                <p class="text-gray-400 text-sm mt-1">Manage and organize content displayed on the homepage</p>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-700">
                    <thead>
                        <tr class="bg-gray-750">
                            <th class="px-6 py-3.5 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Title</th>
                            <th class="px-6 py-3.5 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Content</th>
                            <th class="px-6 py-3.5 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3.5 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-gray-800 divide-y divide-gray-700">
                        @forelse($stories as $story)
                        <tr class="hover:bg-gray-750 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-gray-200 font-medium">{{ $story->title }}</div>
                                <div class="text-gray-400 text-xs mt-1">{{ $story->subtitle }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-gray-300 text-sm line-clamp-2">{{ Str::limit($story->body, 80) }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $story->status === 'active' ? 'bg-green-900/40 text-green-300 border border-green-600/30' : 'bg-red-900/40 text-red-300 border border-red-600/30' }}">
                                    <span class="w-1.5 h-1.5 mr-1.5 rounded-full {{ $story->status === 'active' ? 'bg-green-400 animate-pulse' : 'bg-red-400' }}"></span>
                                    {{ $story->status === 'active' ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex space-x-2">
                                    <a href="?edit_story={{ $story->id }}" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded-md text-sm transition-colors flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        Edit
                                    </a>
                                    <a href="/admin/homepage-story/{{ $story->id }}/toggle-status" class="bg-amber-600 hover:bg-amber-700 text-white px-3 py-1.5 rounded-md text-sm transition-colors flex items-center">
                                        @if($story->status === 'active')
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            Disable
                                        @else
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            Enable
                                        @endif
                                    </a>
                                    <form action="/admin/homepage-story/{{ $story->id }}/delete" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1.5 rounded-md text-sm transition-colors flex items-center" onclick="return confirm('Are you sure you want to delete this story?')">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-gray-400">
                                <svg class="w-12 h-12 mx-auto text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                                <p class="text-lg font-medium">No stories found</p>
                                <p class="mt-1">Click "Add New Story" to create your first story</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($stories->count() > 0 && $stories->hasPages())
            <div class="px-6 py-3 border-t border-gray-700 bg-gray-750">
                {{ $stories->links() }}
            </div>
            @endif
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
    <div id="addStoryModal" class="hidden fixed top-0 inset-0 bg-black bg-opacity-70 backdrop-blur-md overflow-y-auto h-full w-full z-50 transition-opacity duration-300">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="relative bg-gray-800 rounded-xl shadow-2xl w-full max-w-[700px] mx-auto transform transition-all duration-300 scale-95 border border-gray-700"
                id="modalContent">
                <div class="flex justify-between items-center p-6 border-b border-gray-700 bg-gray-850">
                    <h5 class="text-xl font-bold text-white">Add New Story</h5>
                    <button type="button" class="text-gray-400 hover:text-gray-200 transition-colors duration-200 focus:outline-none"
                        onclick="closeModal('addStoryModal')">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                @if ($errors->any())
                <div class="p-4 bg-red-900/80 text-red-200 rounded-md mx-6 my-3 shadow-inner">
                    <div class="flex items-center mb-1">
                        <svg class="w-5 h-5 mr-2 text-red-300" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zm-1 9a1 1 0 01-1-1v-4a1 1 0 112 0v4a1 1 0 01-1 1z" clip-rule="evenodd"/>
                        </svg>
                        <span class="font-medium">Please correct the following errors:</span>
                    </div>
                    <ul class="list-disc list-inside pl-2 text-sm space-y-1">
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
                                <label for="title" class="block text-sm font-semibold text-gray-300 mb-1.5">Story Title</label>
                                <input type="text" class="w-full px-4 py-2.5 rounded-lg border border-gray-600 bg-gray-700 text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 @error('title') border-red-500 @enderror"
                                    id="title" name="title" placeholder="Enter engaging story title" required value="{{ old('title') }}">
                                @error('title')
                                <p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="subtitle" class="block text-sm font-semibold text-gray-300 mb-1.5">Story Subtitle</label>
                                <input type="text" class="w-full px-4 py-2.5 rounded-lg border border-gray-600 bg-gray-700 text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 @error('subtitle') border-red-500 @enderror"
                                    id="subtitle" name="subtitle" placeholder="Enter descriptive subtitle" required value="{{ old('subtitle') }}">
                                @error('subtitle')
                                <p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="content" class="block text-sm font-semibold text-gray-300 mb-1.5">Content</label>
                                <textarea class="w-full px-4 py-3 rounded-lg border border-gray-600 bg-gray-700 text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 @error('content') border-red-500 @enderror"
                                    id="content" name="content" rows="5" placeholder="Enter compelling story content" required>{{ old('content') }}</textarea>
                                @error('content')
                                <p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="image1" class="block text-sm font-semibold text-gray-300 mb-1.5">Primary Image</label>
                                    <input type="file" class="w-full text-sm text-gray-300 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-gray-600 file:text-gray-200 hover:file:bg-blue-600 transition-colors duration-200 cursor-pointer @error('image_link_1') border-red-500 @enderror"
                                        id="image1" name="image_link_1" accept="image/*" onchange="previewImage(this, 'preview1')">

                                    <div id="preview1" class="mt-3 h-44 bg-gray-750 rounded-lg border-2 border-dashed border-gray-600 flex items-center justify-center transition-all duration-200 hover:border-blue-400">
                                        <div class="text-center px-4">
                                            <svg class="mx-auto h-10 w-10 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            <p class="mt-1 text-sm text-gray-400">Click to upload or drag and drop</p>
                                        </div>
                                    </div>
                                    @error('image_link_1')
                                    <p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="image2" class="block text-sm font-semibold text-gray-300 mb-1.5">Secondary Image</label>
                                    <input type="file" class="w-full text-sm text-gray-300 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-gray-600 file:text-gray-200 hover:file:bg-blue-600 transition-colors duration-200 cursor-pointer @error('image_link_2') border-red-500 @enderror"
                                        id="image2" name="image_link_2" accept="image/*" onchange="previewImage(this, 'preview2')">

                                    <div id="preview2" class="mt-3 h-44 bg-gray-750 rounded-lg border-2 border-dashed border-gray-600 flex items-center justify-center transition-all duration-200 hover:border-blue-400">
                                        <div class="text-center px-4">
                                            <svg class="mx-auto h-10 w-10 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            <p class="mt-1 text-sm text-gray-400">Click to upload or drag and drop</p>
                                        </div>
                                    </div>
                                    @error('image_link_2')
                                    <p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="px-8 py-6 bg-gray-850 rounded-b-xl flex items-center justify-end space-x-3">
                        <button type="button"
                            class="px-5 py-2.5 text-sm font-medium text-gray-300 bg-gray-700 border border-gray-600 rounded-lg hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 transition-colors duration-200"
                            onclick="closeModal('addStoryModal')">Cancel</button>
                        <button type="submit"
                            class="px-6 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-200 flex items-center">
                            <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd"/>
                            </svg>
                            Save Story
                        </button>
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