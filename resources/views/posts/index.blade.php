<x-app-layout>

    {{-- HEADER --}}
    <x-slot name="header">    
        {{ __('Posts') }}
    </x-slot>

    {{-- PAGE TITLE --}}
    <h1 class="text-3xl font-bold text-center mb-6
        text-gray-900 dark:text-white transition-colors duration-300">

        Latest Posts

    </h1>

    {{-- FILTER BOX --}}
    <div class="rounded-2xl p-4 mb-8 border shadow-sm transition-all duration-300

        <!-- Left: Filters -->
        <form action="{{ route('posts.index') }}" method="GET"
            class="flex flex-col md:flex-row gap-3 flex-1">

        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">


                {{-- TYPE --}}
                <select name="type"
                    class="px-4 py  -2 rounded-xl border transition

                    bg-gray-50 border-gray-300 text-gray-800
                    focus:border-blue-500 focus:ring-blue-500

                    dark:bg-gray-800 dark:border-gray-700 dark:text-gray-200">

                    <option value="">All Types</option>
                    <option value="post"
                        @selected(request('type') == 'post')>
                        Posts
                    </option>
                    <option value="news"
                        @selected(request('type') == 'news')>
                        News
                    </option>
                @endforeach

            </select>

            <!-- Filter Button -->
            <button type="submit"
                class="bg-blue-600 hover:bg-blue-800 text-white font-bold px-5 py-2 rounded-md transition">
                Filter
            </button>
            
            <!-- Reset -->
            <a href="{{ route('posts.index') }}"
                class="text-gray-300 hover:text-white underline text-sm self-center">
                Reset Filter
            </a>
        </form>
        
        <!-- Right: Create Button -->
        <div class="flex justify-end">

            @can('create', App\Models\Post::class)
                <a href="{{ route('posts.create') }}"
                    class="bg-green-600 hover:bg-green-700 text-white font-bold px-6 py-2 rounded-md shadow-md transition transform hover:scale-105">
                    + Create Post
                </a>
            @endcan

            {{-- Trash Button --}}
            <a href="{{ route('posts.trash') }}"
                class="bg-gray-600 ml-6 hover:bg-gray-700 text-white font-bold px-6 py-2 rounded-md shadow-md transition">
                🗑 Recycle Bin ({{ $trashedCount }})
            </a>
        </div>

    </div>

</div>
    {{-- POSTS --}}
    @if($posts->isEmpty())

        <x-ui.empty-state message="No posts available. Please create one." />

    @else

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">

            @foreach($posts as $post)

                <x-article.content-card :item="$post" />

            @endforeach

        </div>

    @endif

    {{-- PAGINATION --}}
    <div class="p-4">

        {{ $posts->appends(request()->query())->links() }}

    </div>

</x-app-layout>