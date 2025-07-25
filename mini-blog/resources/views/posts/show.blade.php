<x-app-layout>
  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-pink-100 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-rose-900">

          <!-- Title -->
          <h1 class="text-3xl font-bold mb-4">{{ $post->title }}</h1>

          <!-- Body: prose but no auto-margins -->
          <div class="prose max-w-none mx-0 mb-6">
            {{ $post->body }}
          </div>

          <!-- Buttons, flush left -->
          <div class="flex items-center space-x-4">
            <a
              href="{{ route('dashboard') }}"
              class="flex h-10 items-center justify-center px-4 rounded bg-rose-500 text-white hover:bg-rose-600 transition"
            >
              Back
            </a>

            @can('delete', $post)
              <form action="{{ route('posts.destroy', $post) }}" method="POST" class="flex">
                @csrf
                @method('DELETE')
                <button
                  type="submit"
                  class="flex h-10 items-center justify-center px-4 rounded bg-pink-500 text-white hover:bg-pink-600 transition"
                >
                  Delete Post
                </button>
              </form>
            @endcan
          </div>

        </div>
      </div>
    </div>
  </div>
</x-app-layout>