<x-app-layout>
  <x-slot name="header">
    <div class="bg-rose-300 flex justify-between items-center px-6 py-4">
      <a href="{{ route('admin.dashboard') }}" class="font-bold text-2xl text-white">
        Mini Blog
      </a>
      <div class="flex items-center space-x-4">
        <x-dropdown align="right" width="48">
          <x-slot name="trigger">
            <button class="flex items-center text-white font-semibold">
              <span>{{ auth()->user()->name }}</span>
              <svg class="ml-1 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                      d="M19 9l-7 7-7-7"/>
              </svg>
            </button>
          </x-slot>
          <x-slot name="content">
            <x-dropdown-link href="{{ route('profile.edit') }}">Profile</x-dropdown-link>
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <x-dropdown-link :href="route('logout')"
                onclick="event.preventDefault(); this.closest('form').submit()">
                Log Out
              </x-dropdown-link>
            </form>
          </x-slot>
        </x-dropdown>

        <a href="{{ route('posts.create') }}"
           class="px-4 py-2 bg-pink-600 text-white rounded hover:bg-pink-700 font-semibold">
          New Post
        </a>
      </div>
    </div>
  </x-slot>

  <main class="container mx-auto px-6 py-8">
    @php
      // fetch the tab index from ?tab= in the URL (default to 0)
      $initialTab = request()->query('tab', 0);

      if (auth()->user()->hasRole('admin')) {
          $allPosts     = \App\Models\Post::where('status','published')->latest()->paginate(10);
          $pendingPosts = \App\Models\Post::where('status','pending')  ->latest()->paginate(10);
          $deletedPosts = \App\Models\Post::where('status','deleted')  ->latest()->paginate(10);
      } else {
          $allPosts     = auth()->user()->posts()->where('status','published')->latest()->paginate(10);
          $pendingPosts = collect();
          $deletedPosts = collect();
      }
    @endphp

    <div
      x-data="{ tab: {{ $initialTab }} }"
      class="mb-6"
    >
      {{-- Tabs Navigation --}}
      <div class="flex space-x-1 bg-pink-100 p-1 rounded-xl">
        <button @click="tab = 0"
                :class="tab===0
                  ? 'bg-white shadow text-pink-800'
                  : 'text-pink-600 hover:bg-white/50'"
                class="flex-1 rounded-lg py-2.5 text-sm font-medium transition">
          All Posts
        </button>
        <button @click="tab = 1"
                :class="tab===1
                  ? 'bg-white shadow text-pink-800'
                  : 'text-pink-600 hover:bg-white/50'"
                class="flex-1 rounded-lg py-2.5 text-sm font-medium transition">
          Pending
        </button>
        <button @click="tab = 2"
                :class="tab===2
                  ? 'bg-white shadow text-pink-800'
                  : 'text-pink-600 hover:bg-white/50'"
                class="flex-1 rounded-lg py-2.5 text-sm font-medium transition">
          Deleted
        </button>
      </div>

      {{-- All Posts Panel --}}
      <section x-show="tab===0" class="mt-4 overflow-x-auto bg-white rounded-lg shadow">
        <table class="min-w-full">
          <thead class="bg-pink-200">
            <tr>
              <th class="px-4 py-3 text-left">Title</th>
              <th class="px-4 py-3 text-left">Author</th>
              <th class="px-4 py-3 text-left">Created</th>
              <th class="px-4 py-3 text-left">Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($allPosts as $post)
              <tr class="border-t">
                <td class="px-4 py-2">{{ $post->title }}</td>
                <td class="px-4 py-2">{{ $post->user->name }}</td>
                <td class="px-4 py-2">{{ $post->created_at->format('M d, Y') }}</td>
                <td class="px-4 py-2 space-x-2">
                  <a href="{{ route('posts.show',$post) }}"
                     class="px-3 py-1 bg-pink-200 text-pink-800 rounded-full uppercase text-xs font-semibold">
                    View
                  </a>
                  <a href="{{ route('posts.edit',$post) }}"
                     class="px-3 py-1 bg-pink-200 text-pink-800 rounded-full uppercase text-xs font-semibold">
                    Edit
                  </a>
                  <form action="{{ route('posts.destroy',$post) }}" method="POST" class="inline">
                    @csrf @method('DELETE')
                    <button type="submit"
                            class="px-3 py-1 bg-pink-200 text-pink-800 rounded-full uppercase text-xs font-semibold">
                      Delete
                    </button>
                  </form>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="4" class="px-4 py-8 text-center text-gray-500">
                  No published posts.
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
        <div class="mt-4">{{ $allPosts->links() }}</div>
      </section>

      {{-- Pending Panel --}}
      <section x-show="tab===1" class="mt-4 overflow-x-auto bg-white rounded-lg shadow">
        <table class="min-w-full">
          <thead class="bg-pink-200">
            <tr>
              <th class="px-4 py-3 text-left">Title</th>
              <th class="px-4 py-3 text-left">Author</th>
              <th class="px-4 py-3 text-left">Submitted</th>
              <th class="px-4 py-3 text-left">Review</th>
            </tr>
          </thead>
          <tbody>
            @forelse($pendingPosts as $post)
              <tr class="border-t">
                <td class="px-4 py-2">{{ $post->title }}</td>
                <td class="px-4 py-2">{{ $post->user->name }}</td>
                <td class="px-4 py-2">{{ $post->created_at->format('M d, Y') }}</td>
                <td class="px-4 py-2 space-x-2">
                  {{-- Approve routes back with ?tab=0 --}}
                  <form action="{{ route('admin.posts.approve',$post) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit"
                            class="px-3 py-1 bg-green-200 text-green-800 rounded-full uppercase text-xs font-semibold">
                      Approve
                    </button>
                  </form>
                  <form action="{{ route('admin.posts.reject',$post) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit"
                            class="px-3 py-1 bg-red-200 text-red-800 rounded-full uppercase text-xs font-semibold">
                      Delete
                    </button>
                  </form>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="4" class="px-4 py-8 text-center text-gray-500">
                  No posts pending.
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
        <div class="mt-4">{{ $pendingPosts->links() }}</div>
      </section>

      {{-- Deleted Panel --}}
      <section x-show="tab===2" class="mt-4 overflow-x-auto bg-white rounded-lg shadow">
        <table class="min-w-full">
          <thead class="bg-pink-200">
            <tr>
              <th class="px-4 py-3 text-left">Title</th>
              <th class="px-4 py-3 text-left">Author</th>
              <th class="px-4 py-3 text-left">Deleted On</th>
            </tr>
          </thead>
          <tbody>
            @forelse($deletedPosts as $post)
              <tr class="border-t">
                <td class="px-4 py-2">{{ $post->title }}</td>
                <td class="px-4 py-2">{{ $post->user->name }}</td>
                <td class="px-4 py-2">{{ $post->updated_at->format('M d, Y') }}</td>
              </tr>
            @empty
              <tr>
                <td colspan="3" class="px-4 py-8 text-center text-gray-500">
                  No deleted posts.
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
        <div class="mt-4">{{ $deletedPosts->links() }}</div>
      </section>
    </div>
  </main>
</x-app-layout>
