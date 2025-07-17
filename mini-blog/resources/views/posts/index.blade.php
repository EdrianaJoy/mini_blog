<x-app-layout>
  <x-slot name="header">
    <div class="flex justify-between items-center">
      <h2 class="font-semibold text-xl">All Posts</h2>
      <a href="{{ route('posts.create') }}"
         class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
        New Post
      </a>
    </div>
  </x-slot>

  <div class="py-6">
    @if(session('success'))
      <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
        {{ session('success') }}
      </div>
    @endif

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
            <tr class="border-t">
              <td class="px-4 py-2">
                <a href="{{ route('posts.show', $post) }}"
                   class="text-blue-600 hover:underline">
                  {{ $post->title }}
                </a>
              </td>
              <td class="px-4 py-2">{{ $post->user->name }}</td>
              <td class="px-4 py-2">{{ $post->created_at->diffForHumans() }}</td>
              <td class="px-4 py-2 space-x-2">
                <a href="{{ route('posts.show', $post) }}"
                   class="text-indigo-600 hover:underline">View</a>

                @can('update', $post)
                  <a href="{{ route('posts.edit', $post) }}"
                     class="text-yellow-600 hover:underline">Edit</a>
                @endcan

                @can('delete', $post)
                  <form action="{{ route('posts.destroy', $post) }}"
                        method="POST"
                        class="inline"
                        onsubmit="return confirm('Delete this post?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="text-red-600 hover:underline">
                      Delete
                    </button>
                  </form>
                @endcan
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>

      <div class="mt-4">
        {{ $posts->links() }}
      </div>
    @else
      <p class="text-gray-600">No posts yet. <a href="{{ route('posts.create') }}" class="text-blue-600 hover:underline">Create one!</a></p>
    @endif
  </div>
</x-app-layout>
