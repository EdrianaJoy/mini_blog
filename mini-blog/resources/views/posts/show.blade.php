<x-app-layout>
  <main class="min-h-screen bg-orange-100 py-12">
    <div class="container mx-auto px-4">

      <article class="max-w-2xl mx-auto bg-pink-100 rounded-2xl overflow-hidden shadow-lg">
        {{-- Header: big pink bar with title --}}
        <header class="bg-rose-300 px-8 py-6 rounded-t-2xl">
          <h1 class="text-4xl font-extrabold text-pink-900">
            {{ $post->title }}
          </h1>
        </header>

        {{-- Body --}}
        <section class="px-8 py-6 bg-pink-50">
          <div class="prose prose-pink prose-lg max-w-none">
            {!! nl2br(e($post->body)) !!}
          </div>
        </section>

        {{-- Footer: status + actions --}}
        <footer class="px-8 py-6 bg-pink-50 border-t border-rose-300 flex items-center justify-between">
          {{-- Status pill --}}
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

          {{-- Action buttons --}}
          <div class="flex space-x-4">
            <a href="{{ route('posts.index') }}"
               class="inline-flex h-10 items-center justify-center px-4 rounded-full bg-white text-pink-800 font-semibold uppercase text-xs shadow hover:bg-white/80 transition">
              Back
            </a>

            @can('update', $post)
              <a href="{{ route('posts.edit', $post) }}"
                 class="inline-flex h-10 items-center justify-center px-4 rounded-full bg-white text-pink-800 font-semibold uppercase text-xs shadow hover:bg-white/80 transition">
                Edit
              </a>
            @endcan

            @can('delete', $post)
              <form action="{{ route('posts.destroy', $post) }}" method="POST" class="inline">
                @csrf @method('DELETE')
                <button type="submit"
                        class="inline-flex h-10 items-center justify-center px-4 rounded-full bg-red-200 text-red-800 font-semibold uppercase text-xs shadow hover:bg-red-200/80 transition">
                  Delete
                </button>
              </form>
            @endcan
          </div>
        </footer>
      </article>

    </div>
  </main>
</x-app-layout>
