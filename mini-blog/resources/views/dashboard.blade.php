<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-pink-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="mt-6 bg-white p-6 rounded shadow">
                    <h3 class="font-bold mb-4">Your Posts</h3>
                    @if(auth()->user()->posts->count())
                        <table class="min-w-full bg-white shadow rounded">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2 text-left">Title</th>
                                    <th class="px-4 py-2 text-left">Created</th>
                                    <th class="px-4 py-2 text-left">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(auth()->user()->posts as $post)
                                    <tr class="border-t">
                                        <td class="px-4 py-2">
                                            <a href="{{ route('posts.show', $post) }}" class="text-pink-600 hover:underline">
                                                {{ $post->title }}
                                            </a>
                                        </td>
                                        <td class="px-4 py-2">{{ $post->created_at->diffForHumans() }}</td>
                                        <td class="px-4 py-2 space-x-2">
                                            <a href="{{ route('posts.show', $post) }}" class="text-rose-600 hover:underline">View</a>
                                            @can('update', $post)
                                                <a href="{{ route('posts.edit', $post) }}" class="text-orange-600 hover:underline">Edit</a>
                                            @endcan
                                            @can('delete', $post)
                                                <form action="{{ route('posts.destroy', $post) }}" method="POST" class="inline" onsubmit="return confirm('Delete this post?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-pink-600 hover:underline">Delete</button>
                                                </form>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="text-gray-600">No posts yet. <a href="{{ route('posts.create') }}" class="text-rose-600 hover:underline">Create one!</a></p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>