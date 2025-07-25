<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-pink-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    @php
        $posts = auth()->user()
                     ->posts()
                     ->latest()
                     ->get();
    @endphp

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if($posts->count())
                <!-- grid with stretched items -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 items-stretch">
                    @foreach($posts as $post)
                        <!-- make each card a columnar flexbox -->
                        <div class="bg-pink-300 rounded-3xl p-6 shadow-lg flex flex-col h-full">
                            
                            <!-- Title Header: fixed min-height -->
                            <div class="bg-pink-50 rounded-2xl px-4 py-3 mb-4 min-h-[64px]">
                                <h4 class="text-xl font-bold text-rose-500">{{ $post->title }}</h4>
                            </div>
                            
                            <!-- Blog Content: flex-grow to fill space -->
                            <div class="bg-pink-100 rounded-2xl p-4 mb-4 flex-1">
                                <p class="text-rose-900 font-medium">
                                    {{ Str::limit($post->body, 100) }}
                                </p>
                            </div>
                            
                            <!-- Action Buttons: push to bottom with mt-auto -->
                            <div class="flex justify-between space-x-2 mt-auto">
                                <a href="{{ route('posts.show', $post) }}" 
                                   class="bg-pink-50 text-rose-900 px-6 py-2 rounded-full font-semibold hover:bg-orange-100 hover:text-rose-500 transition">
                                    View
                                </a>

                                @can('update', $post)
                                <a href="{{ route('posts.edit', $post) }}" 
                                   class="bg-pink-50 text-rose-900 px-6 py-2 rounded-full font-semibold hover:bg-orange-100 hover:text-rose-500 transition">
                                    Edit
                                </a>
                                @endcan

                                @can('delete', $post)
                                <form action="{{ route('posts.destroy', $post) }}" method="POST" class="inline" onsubmit="return confirm('Delete this post?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-pink-50 text-rose-900 px-6 py-2 rounded-full font-semibold hover:bg-orange-100 hover:text-rose-500 transition">
                                        Delete
                                    </button>
                                </form>
                                @endcan
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-pink-600">
                    No posts yet. 
                    <a href="{{ route('posts.create') }}" class="text-rose-600 hover:underline">
                        Create one!
                    </a>
                </p>
            @endif
        </div>
    </div>
</x-app-layout>
