<x-app-layout>
  <x-slot name="header">
    <div class="flex justify-between items-center">
      <h2 class="font-semibold text-xl text-rose-600">All Posts</h2>
      <div class="flex space-x-2">
        <a href="{{ route('posts.create') }}"
           class="px-4 py-2 bg-pink-600 text-white rounded hover:bg-rose-700 font-semibold">
          New Post
        </a>
        <!-- Dropdown for more actions -->
        <x-ui.dropdown align="right" width="48">
            <x-slot name="trigger">
                <button class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">
                    Actions ▼
                </button>
            </x-slot>
            <x-slot name="content">
                <div class="py-1">
                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Export Posts</a>
                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Import Posts</a>
                    <button @click="$dispatch('open-modal', 'bulk-actions')" 
                            class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        Bulk Actions
                    </button>
                </div>
            </x-slot>
        </x-ui.dropdown>
      </div>
    </div>
  </x-slot>

  <div class="py-6">
    <!-- Success message with auto-hide -->
    @if(session('success'))
      <div 
        x-data="{ show: true }" 
        x-init="setTimeout(() => show = false, 3000)" 
        x-show="show"
        class="bg-green-100 text-green-900 p-4 rounded mb-4 transition-all"
      >
        {{ session('success') }}
      </div>
    @endif

    <!-- Tabs for different views -->
    <x-ui.tabs default-tab="0">
        <div class="flex space-x-1 rounded-xl bg-pink-100 p-1 mb-6">
            <button @click="activeTab = 0" 
                    :class="{ 'bg-white shadow text-pink-800': activeTab === 0, 'text-pink-600 hover:bg-white/50': activeTab !== 0 }"
                    class="w-full rounded-lg py-2.5 text-sm font-medium transition">
                All Posts
            </button>
            <button @click="activeTab = 1" 
                    :class="{ 'bg-white shadow text-pink-800': activeTab === 1, 'text-pink-600 hover:bg-white/50': activeTab !== 1 }"
                    class="w-full rounded-lg py-2.5 text-sm font-medium transition">
                Published
            </button>
            <button @click="activeTab = 2" 
                    :class="{ 'bg-white shadow text-pink-800': activeTab === 2, 'text-pink-600 hover:bg-white/50': activeTab !== 2 }"
                    class="w-full rounded-lg py-2.5 text-sm font-medium transition">
                Drafts
            </button>
        </div>

        <!-- All Posts Tab -->
        <div x-show="activeTab === 0">
            @if($posts->count())
              <table class="min-w-full bg-white shadow rounded">
                <thead>
                  <tr>
                    <th class="px-4 py-2">Title</th>
                    <th class="px-4 py-2">Author</th>
                    <th class="px-4 py-2">Created</th>
                    <th class="px-4 py-2">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($posts as $post)
                  <tr>
                    <td class="px-4 py-2">{{ $post->title }}</td>
                    <td class="px-4 py-2">{{ $post->user->name }}</td>
                    <td class="px-4 py-2">{{ $post->created_at->format('M d, Y') }}</td>
                    <td class="px-4 py-2">
                        <!-- Dropdown for post actions -->
                        <x-ui.dropdown align="left" width="48">
                            <x-slot name="trigger">
                                <button class="text-gray-400 hover:text-gray-600">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path>
                                    </svg>
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                <div class="py-1">
                                    <a href="{{ route('posts.show', $post) }}" 
                                       class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">View</a>
                                    <a href="{{ route('posts.edit', $post) }}" 
                                       class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Edit</a>
                                    <button @click="$dispatch('open-modal', 'delete-post-{{ $post->id }}')" 
                                            class="block w-full text-left px-4 py-2 text-sm text-red-700 hover:bg-gray-100">
                                        Delete
                                    </button>
                                </div>
                            </x-slot>
                        </x-ui.dropdown>
                    </td>
                  </tr>

                  <!-- Delete confirmation modal for each post -->
                  <x-ui.modal name="delete-post-{{ $post->id }}" max-width="md">
                      <div class="p-6">
                          <h3 class="text-lg font-medium text-gray-900 mb-4">Delete Post</h3>
                          <p class="text-gray-600 mb-4">Are you sure you want to delete "{{ $post->title }}"? This action cannot be undone.</p>
                          <div class="flex justify-end space-x-3">
                              <button @click="$dispatch('close-modal', 'delete-post-{{ $post->id }}')" 
                                      class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400">
                                  Cancel
                              </button>
                              <form action="{{ route('posts.destroy', $post) }}" method="POST" class="inline">
                                  @csrf
                                  @method('DELETE')
                                  <button type="submit" 
                                          class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700">
                                      Delete Post
                                  </button>
                              </form>
                          </div>
                      </div>
                  </x-ui.modal>
                  @endforeach
                </tbody>
              </table>
            @else
              <p class="text-gray-500 text-center py-8">No posts found.</p>
            @endif
        </div>

        <!-- Published Tab -->
        <div x-show="activeTab === 1">
            <p class="text-gray-500 text-center py-8">Published posts will be shown here.</p>
        </div>

        <!-- Drafts Tab -->
        <div x-show="activeTab === 2">
            <p class="text-gray-500 text-center py-8">Draft posts will be shown here.</p>
        </div>
    </x-ui.tabs>

    <!-- Bulk Actions Modal -->
    <x-ui.modal name="bulk-actions" max-width="md">
        <div class="p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Bulk Actions</h3>
            <div class="space-y-4">
                <label class="flex items-center">
                    <input type="radio" name="bulk_action" value="delete" class="mr-2">
                    <span>Delete Selected Posts</span>
                </label>
                <label class="flex items-center">
                    <input type="radio" name="bulk_action" value="publish" class="mr-2">
                    <span>Publish Selected Posts</span>
                </label>
                <label class="flex items-center">
                    <input type="radio" name="bulk_action" value="draft" class="mr-2">
                    <span>Move to Drafts</span>
                </label>
            </div>
            <div class="mt-6 flex justify-end space-x-3">
                <button @click="$dispatch('close-modal', 'bulk-actions')" 
                        class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400">
                    Cancel
                </button>
                <button class="bg-pink-600 text-white px-4 py-2 rounded-md hover:bg-pink-700">
                    Apply Actions
                </button>
            </div>
        </div>
    </x-ui.modal>
  </div>
</x-app-layout>