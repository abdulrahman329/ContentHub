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

        bg-white border-gray-200
        dark:bg-gray-900 dark:border-gray-800">

        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

            {{-- FILTERS FORM --}}
            <x-ui.buttons.actions.form
                action="{{ route('posts.index')}}"
                method="GET"
                class="flex flex-col sm:flex-row gap-3 flex-1">

                {{-- TYPE --}}
                <select name="type"
                    class="px-4 py-2 rounded-xl border transition

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
                </select>

                {{-- CATEGORY --}}
                <select name="category_id"
                    class="px-4 py-2 rounded-xl border transition

                    bg-gray-50 border-gray-300 text-gray-800
                    focus:border-blue-500 focus:ring-blue-500

                    dark:bg-gray-800 dark:border-gray-700 dark:text-gray-200">

                    <option value="">All Categories</option>

                    @foreach($categories as $category)

                        <option value="{{ $category->id }}"
                            @selected(request('category_id') == $category->id)>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>

                {{-- FILTER BUTTON --}}
                <x-ui.buttons.variants 
                type="submit" 
                variant="create">
                    Filter
                </x-ui.buttons.variants>
            </x-ui.buttons.actions.form>

            {{-- ACTIONS --}}
            <div class="flex items-center gap-3 justify-end">

                {{-- RESET FILTER --}}
                <x-ui.buttons.actions.link
                href="{{ route('posts.index') }}">
                    <x-ui.buttons.variants variant="reset">
                        Reset Filter
                    </x-ui.buttons.variants>
                </x-ui.buttons.actions.link>

                {{-- Create POST --}}
                @can('create', App\Models\Post::class)
                    <x-ui.buttons.actions.link
                        href="{{ route('posts.create') }}">
                        <x-ui.buttons.variants variant="create">
                            Create
                        </x-ui.buttons.variants>
                    </x-ui.buttons.actions.link>
                @endcan

                {{-- TRASH --}}
                <x-ui.buttons.actions.link
                    href="{{ route('posts.trash') }}">
                    <x-ui.buttons.variants variant="trash">
                        🗑 {{ $trashedCount }}
                    </x-ui.buttons.variants>
                </x-ui.buttons.actions.link>
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