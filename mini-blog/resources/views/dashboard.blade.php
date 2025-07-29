<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-pink-800 leading-tight">
      {{ __('Dashboard') }}
    </h2>
  </x-slot>

  @php
    $posts = auth()->user()->posts()->latest()->get();
  @endphp

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      @if($posts->count())
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 items-stretch">
          @foreach($posts as $post)
            <div class="bg-pink-300 rounded-3xl p-6 shadow-lg flex flex-col h-full">
              
              <!-- Title -->
              <div class="bg-pink-50 rounded-2xl px-4 py-3 mb-4 min-h-[64px]">
                <h4 class="text-xl font-bold text-rose-500">{{ $post->title }}</h4>
              </div>
              
              <!-- Excerpt -->
              <div class="bg-pink-100 rounded-2xl p-4 mb-4 flex-1">
                {{ Str::limit($post->body, 100) }}
              </div>

              <!-- Action buttons -->
              <div class="mt-auto flex justify-end space-x-2">
                <a href="{{ route('posts.show', $post) }}"
                   class="px-4 py-2 bg-pink-600 text-white rounded hover:bg-rose-700">
                  View
                </a>
                <a href="{{ route('posts.edit', $post) }}"
                   class="px-4 py-2 border border-pink-600 text-pink-600 rounded hover:bg-pink-50">
                  Edit
                </a>
              </div>
            </div>
          @endforeach
        </div>
      @else
        <p class="text-gray-500 text-center">No posts yet.</p>
      @endif
    </div>
  </div>
</x-app-layout>