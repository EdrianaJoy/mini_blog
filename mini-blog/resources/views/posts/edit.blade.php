<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl">Edit Post</h2>
  </x-slot>

  <div class="py-6 max-w-2xl mx-auto">
    @if($errors->any())
      <div class="mb-4 p-4 bg-red-100 text-red-800 rounded">
        <ul class="list-disc pl-5">
          @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form action="{{ route('posts.update', $post) }}" method="POST">
      @csrf
      @method('PUT')

      <div class="mb-4">
        <label for="title" class="block font-medium">Title</label>
        <input id="title"
               name="title"
               type="text"
               value="{{ old('title', $post->title) }}"
               class="w-full mt-1 p-2 border rounded"
               required>
      </div>

      <div class="mb-4">
        <label for="body" class="block font-medium">Body</label>
        <textarea id="body"
                  name="body"
                  rows="8"
                  class="w-full mt-1 p-2 border rounded"
                  required>{{ old('body', $post->body) }}</textarea>
      </div>

      <div class="flex space-x-4">
        <button type="submit"
                class="px-4 py-2 bg-pink-600 text-white rounded hover:bg-pink-700">
          Update
        </button>
        <a href="{{ route('posts.show', $post) }}"
           class="px-4 py-2 bg-pink-200 rounded hover:bg-pink-300">
          Cancel
        </a>
      </div>
    </form>
  </div>
</x-app-layout>
