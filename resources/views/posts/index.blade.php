<x-app-layout>
    <!-- Header section -->
    <x-slot name="header">
        <!-- Display 'Posts' heading -->
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            {{ __('Posts') }}
        </h2>
    </x-slot>

    <div class="container mx-auto px-4 py-12">
        <!-- Page Title: Displays the title of the page 'Latest Posts' -->
        <h1 class="text-3xl font-bold my-6 text-center text-white">Latest Posts</h1>
        <div class="text-center mb-4">

        <div class="bg-gray-800 p-6 rounded-lg shadow-lg mb-8">

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

        <!-- Left: Filters -->
        <form action="{{ route('posts.index') }}" method="GET"
            class="flex flex-col md:flex-row gap-3 flex-1">

            <!-- Type Filter -->
            <select name="type"
                class="w-full md:w-auto px-4 py-2 border border-gray-600 rounded-md bg-gray-700 text-gray-300">

                <option value="">All Types</option>
                <option value="post" @selected(request('type') == 'post')>Posts</option>
                <option value="news" @selected(request('type') == 'news')>News</option>

            </select>

            <!-- Category Filter -->
            <select name="category_id"
                class="w-full md:w-auto px-4 py-2 border border-gray-600 rounded-md bg-gray-700 text-gray-300">

                <option value="">All Categories</option>

                @foreach($categories as $category)
                    <option value="{{ $category->id }}"
                        @selected(request('category_id') == $category->id)>
                        {{ $category->name }}
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

        </div>

    </div>

</div>

        <!-- Check if no posts are available, and display a message -->
        @if($posts->isEmpty())
            <div class="text-center text-gray-500 text-lg">No posts available. Please create one.</div>
        @else
            <!-- Display the posts in a grid layout -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                @foreach($posts as $post)
                <x-article.content-card :item="$post" />
                @endforeach
            </div>
        @endif
        <div class='p-4'>
        {{ $posts->appends(request()->query())->links() }}
    </div>
    </div>
</x-app-layout>
