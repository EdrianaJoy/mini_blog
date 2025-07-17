<x-app-layout>
  <x-slot name="header">
    <div class="flex justify-between items-center">
      <h2 class="font-semibold text-xl">{{ $post->title }}</h2>
      <div class="space-x-2">
        <a href="{{ route('posts.index') }}"
           class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300">
          Back
        </a>
        @can('update', $post)
          <a href="{{ route('posts.edit', $post) }}"
             class="px-3 py-1 bg-yellow-200 rounded hover:bg-yellow-300">
            Edit
          </a>
        @endcan
      </div>
    </div>
  </x-slot>

  <div class="py-6">
    <div class="prose">
      {!! nl2br(e($post->body)) !!}
    </div>
    <p class="mt-6 text-sm text-gray-500">
      Posted by {{ $post->user->name }} on {{ $post->created_at->format('M j, Y \a\t g:ia') }}
    </p>

    @can('delete', $post)
      <form action="{{ route('posts.destroy', $post) }}"
            method="POST"
            class="mt-4"
            onsubmit="return confirm('Are you sure?');">
        @csrf
        @method('DELETE')
        <button type="submit"
                class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
          Delete Post
        </button>
      </form>
    @endcan
  </div>
</x-app-layout>
