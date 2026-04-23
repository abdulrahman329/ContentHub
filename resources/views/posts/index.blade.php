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

        <!-- Category Filter Section -->
        <div class="text-center mb-6">
            <!-- Form for category filtering -->
            <form action="{{ route('posts.index') }}" method="GET">
                <!-- Dropdown to select category for filtering posts -->
                <select name="category_id" id="category_id" class="mt-1 block w-full px-3 py-2 border border-gray-600 rounded-md shadow-sm bg-gray-700 text-gray-300">
                    <option value="">All Categories</option> <!-- Option to show all categories -->
                    @foreach($categories as $category)
                        <!-- Loop through all available categories and mark the selected category -->
                        <option value="{{ $category->id }}"> 
                            @if(request('category_id') == $category->id) selected @endif
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                <!-- Filter button to apply selected category -->
                <button type="submit" class="mt-4 bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded-md">
                    Filter
                </button>
            </form>
        </div>

        <!-- Create Post Button (Visible only for users with 'writer' or 'admin' roles) -->
        <div class="text-center mb-6">
        @can('create', App\Models\Post::class)
            <!-- Link to the page where users can create a new post -->
            <a href="{{ route('posts.create') }}" class="inline-block bg-blue-600 hover:bg-blue-800 text-white font-bold py-3 px-6 rounded-md shadow-md transform hover:scale-105 transition-all duration-200 ease-in-out">
                Create Post
            </a>
        @endcan
        </div>

        <!-- Check if no posts are available, and display a message -->
        @if($posts->isEmpty())
            <div class="text-center text-gray-500 text-lg">No posts available. Please create one.</div>
        @else
            <!-- Display the posts in a grid layout -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                @foreach($posts as $post)
                <x-content-card :item="$post" type="posts" />
                @endforeach
            </div>
        @endif
        <div class='p-4'>
    {{ $posts->links() }}  <!-- This will display the pagination links -->
</div>
    </div>
</x-app-layout>
