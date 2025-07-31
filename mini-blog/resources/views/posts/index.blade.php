@props(['posts'])

{{-- Flash --}}
@if(session('success'))
  <div
    x-data="{ show: true }"
    x-init="setTimeout(() => show = false, 3000)"
    x-show="show"
    class="mb-6 p-4 bg-rose-100 text-pink-800 rounded"
  >
    {{ session('success') }}
  </div>
@endif

<x-ui.tabs default-tab="0">
  <div class="flex space-x-1 rounded-xl bg-pink-100 p-1 mb-6">
    <button
      @click="activeTab = 0"
      :class="activeTab === 0 ? 'bg-white shadow text-pink-800' : 'text-pink-600 hover:bg-white/50'"
      class="flex-1 rounded-lg py-2.5 text-sm font-medium transition"
    >All Posts</button>
    <button
      @click="activeTab = 1"
      :class="activeTab === 1 ? 'bg-white shadow text-pink-800' : 'text-pink-600 hover:bg-white/50'"
      class="flex-1 rounded-lg py-2.5 text-sm font-medium transition"
    >Published</button>
    <button
      @click="activeTab = 2"
      :class="activeTab === 2 ? 'bg-white shadow text-pink-800' : 'text-pink-600 hover:bg-white/50'"
      class="flex-1 rounded-lg py-2.5 text-sm font-medium transition"
    >Drafts</button>
  </div>

  {{-- All Posts --}}
  <div x-show="activeTab === 0">
    {{-- reuse your grid/article markup --}}
    <div class="grid gap-6 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3">
      @forelse($posts as $post)
        <article class="bg-pink-100 rounded-2xl overflow-hidden shadow-lg flex flex-col">
          <header class="bg-rose-300 px-6 py-4 rounded-t-2xl">
            <h2 class="text-2xl font-extrabold text-pink-900">
              {{ \Illuminate\Support\Str::limit($post->title, 30) }}
            </h2>
          </header>
          <div class="px-6 py-4 flex-1">
            <p class="text-pink-900 mb-4">
              {{ \Illuminate\Support\Str::limit($post->body, 100) }}
            </p>
            @switch($post->status)
              @case('pending')
                <span class="inline-block bg-white text-pink-800 uppercase text-xs font-bold px-3 py-1 rounded-full">
                  Pending Post
                </span>
                @break
              @case('published')
                <span class="inline-block bg-green-200 text-green-800 uppercase text-xs font-bold px-3 py-1 rounded-full">
                  Published
                </span>
                @break
              @case('deleted')
                <span class="inline-block bg-red-200 text-red-800 uppercase text-xs font-bold px-3 py-1 rounded-full">
                  Deleted
                </span>
                @break
            @endswitch
          </div>
          <footer class="px-6 py-4 border-t border-rose-300 flex space-x-3">
            <a href="{{ route('posts.show', $post) }}"
               class="flex-1 h-10 flex items-center justify-center bg-white text-pink-800 rounded-full uppercase text-xs font-semibold shadow hover:bg-white/80 transition">
              View
            </a>
            @can('update',$post)
              <a href="{{ route('posts.edit',$post) }}"
                 class="flex-1 h-10 flex items-center justify-center bg-white text-pink-800 rounded-full uppercase text-xs font-semibold shadow hover:bg-white/80 transition">
                Edit
              </a>
            @endcan
            @can('delete',$post)
              <form action="{{ route('posts.destroy',$post) }}" method="POST" class="flex-1">
                @csrf @method('DELETE')
                <button type="submit"
                        class="w-full h-10 flex items-center justify-center bg-red-200 text-red-800 rounded-full uppercase text-xs font-semibold shadow hover:bg-red-200/80 transition">
                  Delete
                </button>
              </form>
            @endcan
          </footer>
        </article>
      @empty
        <p class="col-span-full text-center text-gray-500 py-12">
          No posts found.
        </p>
      @endforelse
    </div>

    {{-- Pagination --}}
    <div class="mt-8">{{ $posts->links() }}</div>
  </div>

  {{-- Published --}}
  <div x-show="activeTab === 1">
    <p class="text-gray-500 text-center py-8">Published posts will be shown here.</p>
  </div>

  {{-- Drafts / Pending --}}
  <div x-show="activeTab === 2" class="mt-4">
    @if($posts->count())
      <div class="grid gap-6 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3">
        @foreach($posts as $post)
          {{-- identical card as above, but you know status is always “pending” here --}}
          <article class="bg-pink-100 rounded-2xl overflow-hidden shadow-lg flex flex-col">
            <header class="bg-rose-300 px-6 py-4 rounded-t-2xl">
              <h2 class="text-2xl font-extrabold text-pink-900">
                {{ \Illuminate\Support\Str::limit($post->title, 30) }}
              </h2>
            </header>
            <div class="px-6 py-4 flex-1">
              <p class="text-pink-900 mb-4">
                {{ \Illuminate\Support\Str::limit($post->body, 100) }}
              </p>
              <span class="inline-block bg-white text-pink-800 uppercase text-xs font-bold px-3 py-1 rounded-full">
                Pending Post
              </span>
            </div>
            <footer class="px-6 py-4 border-t border-rose-300 flex space-x-3">
              <a href="{{ route('posts.show',$post) }}"
                 class="flex-1 h-10 flex items-center justify-center bg-white text-pink-800 rounded-full uppercase text-xs font-semibold shadow hover:bg-white/80 transition">
                View
              </a>
              @can('update',$post)
                <a href="{{ route('posts.edit',$post) }}"
                   class="flex-1 h-10 flex items-center justify-center bg-white text-pink-800 rounded-full uppercase text-xs font-semibold shadow hover:bg-white/80 transition">
                  Edit
                </a>
              @endcan
              @can('delete',$post)
                <form action="{{ route('posts.destroy',$post) }}" method="POST" class="flex-1">
                  @csrf @method('DELETE')
                  <button type="submit"
                          class="w-full h-10 flex items-center justify-center bg-red-200 text-red-800 rounded-full uppercase text-xs font-semibold shadow hover:bg-red-200/80 transition">
                    Delete
                  </button>
                </form>
              @endcan
            </footer>
          </article>
        @endforeach
      </div>

      {{-- Pagination --}}
      <div class="mt-8">{{ $posts->links() }}</div>
    @else
      <p class="col-span-full text-center text-gray-500 py-12">
        No posts pending review.
      </p>
    @endif
  </div>
</x-ui.tabs>
