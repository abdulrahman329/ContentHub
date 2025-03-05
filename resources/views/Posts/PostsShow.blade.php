<script>
    // This function is triggered when the "Submit Comment" button is clicked
    function handleClick(event, button) {
        // Prevents the default form submission behavior (which reloads the page)
        event.preventDefault();

        // Disables the button to prevent multiple clicks
        button.disabled = true;

        // Manually submits the form after disabling the button
        // 'event.target' refers to the button clicked, so we use 'closest('form')' to find the closest form element
        event.target.closest('form').submit();
    }
</script>

<x-app-layout>
    <!-- Header Section for the page -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            <!-- Page Title displaying "Show Post" -->
            {{ __('Show Post') }}
        </h2>
    </x-slot>

    <div class="container mx-auto px-8 py-12">
        <!-- Post Title: Display the title of the post -->
        <h1 class="text-5xl font-extrabold text-white text-center mb-6">{{ $post->title }}</h1>

        <!-- Image Section: Conditionally displays the post image if it exists -->
        @if($post->image)
            <div class="mb-8 flex justify-center">
                <div class="relative overflow-hidden rounded-lg shadow-xl w-full h-96">
                    <!-- Display the image from the storage using the asset helper -->
                    <img src="{{ filter_var($post->image, FILTER_VALIDATE_URL) ? $post->image : asset('storage/'.$post->image) }}" alt="{{ $post->title }}" class="w-full h-56 object-cover rounded-t-lg">
                    </div>
            </div>
        @endif

        <!-- Post Content Section -->
        <div class="bg-gray-800 p-8 rounded-lg shadow-lg mb-8">
            <!-- Display the category name of the post -->
            <p class="text-lg text-gray-300 mt-4"><strong>Category Name:</strong> <span class="text-gray-400">{{ $post->category->name }}</span></p>
            <!-- Post Content Section -->
            <p class="text-lg text-gray-300 leading-relaxed mb-6"><strong>Content:</strong></p>
            <!-- Display the content of the post -->
            <p class="text-xl text-gray-200">{{ $post->content }}</p>
        </div>

        <!-- Comment Form: Only visible to authenticated users -->
        @auth
        <div class="bg-gray-800 p-8 rounded-lg shadow-lg mb-8">
            <!-- Comment form that sends data to the 'storeComment' route for this post -->
            <form action="{{ route('posts.storeComment', $post->id) }}" method="POST" class="space-y-4">
                @csrf
                <!-- Textarea for user to input their comment -->
                <textarea name="content" class="w-full p-4 text-gray-300 bg-gray-700 border rounded-md" rows="4" placeholder="Write a comment..." required></textarea>
                <!-- Submit button: On click, it calls the handleClick function to disable the button and submit the form -->
                <button type="submit" class="bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-800 w-full" onclick="handleClick(event, this)">Submit Comment</button>
            </form>
        </div>
        @endauth

        <!-- Displaying Comments Section -->
        <div class="bg-gray-800 p-8 rounded-lg shadow-lg">
            <h3 class="text-2xl text-white mb-4">Comments</h3>
            <!-- Loop through each comment associated with the post -->
            @forelse($comments as $comment)
                <div class="bg-gray-700 p-4 rounded-md mb-4">
                    <!-- Display the commenter's name -->
                    <p class="text-gray-300 font-bold">{{ $comment->user->name }}</p>
                    <!-- Display the content of the comment -->
                    <p class="text-gray-300">{{ $comment->content }}</p>

                    <!-- If the logged-in user is the comment owner or an admin, show edit and delete options -->
                    @if($comment->user_id === Auth::id() || Auth::user()->role == 'admin')
                        <div class="flex justify-end space-x-4 mt-4">
                            <!-- Edit Button: Link to the edit page for the specific comment -->
                            <a href="{{ route('posts_comments.edit', $comment->id) }}" class="text-yellow-500 hover:text-yellow-700">Edit</a>
                            <!-- Delete Button: Form that will delete the comment after confirmation -->
                            <form action="{{ route('posts.destroyComment', ['post' => $post->id, 'comment' => $comment->id]) }}" method="POST" class="ml-4">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800" onclick="return confirm('Are you sure you want to delete this Comment?')">Delete</button>
                            </form>
                        </div>
                    @endif

                    <!-- Display the time when the comment was posted -->
                    <p class="text-sm text-gray-400 mt-2">Posted {{ $comment->created_at->diffForHumans() }}</p>
                </div>
            @empty
                <!-- Display a message if no comments are present -->
                <p class="text-gray-400">No comments yet. Be the first to comment!</p>
            @endforelse
        </div>

        <!-- Action Buttons Section: Includes back to posts and post edit/delete buttons -->
        <div class="flex justify-between items-center mt-8">
            <!-- Link back to the posts index page -->
            <a href="{{ route('posts.index') }}" class="text-lg text-white bg-blue-600 hover:bg-blue-800 hover:scale-105 duration-200 px-6 py-2 rounded-md font-semibold transition-all">Back to Posts</a>

            <div class="space-x-6">
                <!-- Edit Button: Only visible if the logged-in user is the post owner or an admin -->
                @if(Auth::id() == $post->user_id || Auth::user()->role == 'admin')
                    <a href="{{ route('posts.edit', $post->id) }}" class="inline-block text-lg text-white bg-yellow-500 hover:bg-yellow-700 hover:scale-105 duration-200 px-6 py-2 rounded-md font-semibold transition-all">Edit</a>
                @endif
                <!-- Delete Button: Only visible if the logged-in user is the post owner or an admin -->
                @if(Auth::id() == $post->user_id || Auth::user()->role == 'admin')
                    <form method="POST" action="{{ route('posts.destroy', $post->id) }}" class="inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-lg text-white bg-red-500 hover:bg-red-800 hover:scale-105 duration-200 px-6 py-2 rounded-md font-semibold transition-all">Delete</button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
