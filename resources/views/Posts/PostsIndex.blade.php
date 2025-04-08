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
        @if(Auth::user()->hasRole('writer') || Auth::user()->hasRole('admin'))
            <!-- Link to the page where users can create a new post -->
            <a href="{{ route('posts.create') }}" class="inline-block bg-blue-600 hover:bg-blue-800 text-white font-bold py-3 px-6 rounded-md shadow-md transform hover:scale-105 transition-all duration-200 ease-in-out">
                Create Post
            </a>
        @endif
        </div>

        <!-- Check if no posts are available, and display a message -->
        @if($posts->isEmpty())
            <div class="text-center text-gray-500 text-lg">No posts available. Please create one.</div>
        @else
            <!-- Display the posts in a grid layout -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                @foreach($posts as $post)
                    <div class="bg-gray-800 text-white rounded-lg shadow-lg overflow-hidden flex flex-col">
                        
                        <!-- Display Post Image -->
                        @if($post->image)
                            <a href="{{ route('posts.show', $post->id) }}">
                                <!-- Show the image of the post -->
                                <img src="{{ filter_var($post->image, FILTER_VALIDATE_URL) ? $post->image : asset('storage/'.$post->image) }}" alt="{{ $post->title }}" class="w-full h-56 object-cover rounded-t-lg">
                            </a>
                        @endif

                        <!-- Post Content Section -->
                        <div class="px-6 py-4 flex-grow">
                            <div class="font-bold text-xl mb-2">{{ $post->title }}</div> <!-- Display the post title -->
                            <p class="text-gray-300 text-sm">
                            {{ Str::limit($post->content, 100, '...') }} <!-- Display a preview of the content (first 100 characters) -->
                            </p>
                        </div>

                        <!-- Action Buttons Section (View, Edit, Delete) -->
                        <div class="px-6 pb-4 mt-auto">
                            <div class="space-y-2">
                                <!-- View Button: Links to the detailed view of the post -->
                                <p>
                                    <a href="{{ route('posts.show', $post->id) }}" class="inline-block bg-blue-600 text-black py-2 px-4 rounded-lg hover:bg-blue-800 transform transition-all duration-200 ease-in-out w-full text-center">
                                        View
                                    </a>
                                </p>

                                <!-- Edit and Delete Buttons: Only visible for the post owner or admin -->
                                @if(Auth::id() === $post->user_id || Auth::user()->hasRole('admin'))
                                    <div class="grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                                        <!-- Edit Button: Link to edit the post -->
                                        <p>
                                            <a href="{{ route('posts.edit', $post->id) }}" class="inline-block bg-yellow-500 text-black py-2 px-4 rounded-lg hover:bg-yellow-700 transform transition-all duration-200 ease-in-out w-full mt-2 text-center">
                                                Edit
                                            </a>
                                        </p>

                                        <!-- Delete Button: Form to delete the post -->
                                        <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="inline-block w-full">
                                            @csrf
                                            @method('DELETE')
                                            <!-- Submit button for deleting the post -->
                                            <button type="submit" class="bg-red-600 text-black py-2 px-4 rounded-lg hover:bg-red-800 transform transition-all duration-200 ease-in-out w-full mt-2 text-center" onclick="return confirm('Are you sure you want to delete this Post?')">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                @endif

                                <!-- Display Post Category and Comment Count -->
                                <div class="mt-2 text-gray-400 text-sm">
                                    <p class="text-lg text-gray-300 mt-4 line-clamp-2"><strong>Category Name:</strong>
                                     <span class="text-gray-400">{{ $post->category->name }}</span></p> <!-- Show the category name -->
                                    <strong>Comments:</strong> {{ $post->comments_count }} <!-- Show the number of comments on the post -->
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
        <div class='p-4'>
    {{ $posts->links() }}  <!-- This will display the pagination links -->
</div>
    </div>
</x-app-layout>
