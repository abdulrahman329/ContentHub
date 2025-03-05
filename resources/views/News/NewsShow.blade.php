<script>
    // This function is called when the button is clicked
    function handleClick(event, button) {
        // Prevent the default form submission behavior (page reload)
        event.preventDefault();

        // Disable the button so it can't be clicked again
        button.disabled = true;
        
        // Now, manually submit the form after the button is disabled
        // 'event.target' is the button that was clicked, so we use 'closest('form')' to find the parent form
        event.target.closest('form').submit();
    }
</script>

<x-app-layout>
    <!-- Header Section for the page -->
    <x-slot name="header">
        <!-- Display the title 'Show News' -->
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            {{ __('Show News') }}
        </h2>
    </x-slot>

    <div class="container mx-auto px-8 py-12">
        <!-- News Title -->
        <h1 class="text-5xl font-extrabold text-white text-center mb-6">{{ $News->title }}</h1>

        <!-- Image Section: Only show if there is an image for the news article -->
        @if($News->image)
            <div class="mb-8 flex justify-center">
                <div class="relative overflow-hidden rounded-lg shadow-xl w-full h-96">
                <img src="{{ filter_var($News->image, FILTER_VALIDATE_URL) ? $News->image : asset('storage/'.$News->image) }}" alt="{{ $News->title }}" class="w-full h-56 object-cover rounded-t-lg">
                </div>
            </div>
        @endif

        <!-- News Content Section -->
        <div class="bg-gray-800 p-8 rounded-lg shadow-lg mb-8">
            <p class="text-lg text-gray-300 mt-4"><strong>Category Name:</strong> <span class="text-gray-400">{{ $News->category->name }}</span></p>
            <br>
            <p class="text-lg text-gray-300 leading-relaxed mb-6"><strong>Content:</strong></p>
            <p class="text-xl text-gray-200">{{ $News->content }}</p>
        </div>

        <!-- Form Section for submitting a new comment -->
        <div class="bg-gray-800 p-8 rounded-lg shadow-lg mb-8">
            <!-- Form to submit a new comment -->
            <form action="{{ route('news.storeComment', $News->id) }}" method="POST" class="space-y-4">
                @csrf <!-- CSRF protection for the form -->
                <textarea name="content" class="w-full p-4 text-gray-300 bg-gray-700 border rounded-md" rows="4" placeholder="Write a comment..." required></textarea>
                <button type="submit" class="bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-800 w-full" onclick="handleClick(event, this)">Submit Comment</button>
            </form>
        </div>

        <!-- Display Comments Section -->
        <div class="bg-gray-800 p-8 rounded-lg shadow-lg">
            <h3 class="text-2xl text-white mb-4">Comments</h3>
            <!-- Loop through the comments if there are any -->
            @forelse($comments as $comment)
                <div class="bg-gray-700 p-4 rounded-md mb-4">
                    <!-- Display the commenter's name -->
                    <p class="text-gray-300 font-bold">{{ $comment->user->name }}</p>

                    <!-- Display the comment content -->
                    <p class="text-gray-300">{{ $comment->content }}</p>

                    <!-- Edit and Delete buttons for the comment if it's the logged-in user or an admin -->
                    @if($comment->user_id === Auth::id() || Auth::user()->role == 'admin')
                        <div class="flex justify-end space-x-4 mt-4">
                            <!-- Link to edit the comment -->
                            <a href="{{ route('news_comments.edit', $comment->id) }}" class="text-yellow-500 hover:text-yellow-700">Edit</a>

                            <!-- Form to delete the comment -->
                            <form action="{{ route('news.destroyComment', ['news' => $News->id, 'comment' => $comment->id]) }}" method="POST" class="ml-4">
                                @csrf
                                @method('DELETE') <!-- Method Spoofing for DELETE -->
                                <button type="submit" class="text-red-600 hover:text-red-800 " onclick="return confirm('Are you sure you want to delete this Post?')">Delete</button>
                            </form>
                        </div>
                    @endif

                    <!-- Display the time the comment was posted -->
                    <p class="text-sm text-gray-400 mt-2">Posted {{ $comment->created_at->diffForHumans() }}</p>
                </div>
            @empty
                <!-- If there are no comments, display a message -->
                <p class="text-gray-400">No comments yet. Be the first to comment!</p>
            @endforelse
        </div>

        <!-- Action Buttons (Back to News and Edit/Delete if owned by the user or an admin) -->
        <div class="flex justify-between items-center mt-8">
            <!-- Button to go back to the news list -->
            <a href="{{ route('News.index') }}" class="text-lg text-white bg-blue-600 hover:bg-blue-800 hover:scale-105 duration-200 px-6 py-2 rounded-md font-semibold transition-all">Back to News</a>

            <div class="space-x-6">
                <!-- Edit Button: Only show if the current user is the owner or an admin -->
                @if(Auth::id() == $News->user_id || Auth::user()->role == 'admin')
                    <a href="{{ route('News.edit', $News->id) }}" class="inline-block text-lg text-white bg-yellow-500 hover:bg-yellow-700 hover:scale-105 duration-200 px-6 py-2 rounded-md font-semibold transition-all">Edit</a>
                @endif
                <!-- Delete Button: Only show if the current user is the owner or an admin -->
                @if(Auth::id() == $News->user_id || Auth::user()->role == 'admin')
                    <form method="POST" action="{{ route('News.destroy', $News->id) }}" class="inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-lg text-white bg-red-500 hover:bg-red-800 hover:scale-105 duration-200 px-6 py-2 rounded-md font-semibold transition-all" onclick="return confirm('Are you sure you want to delete this News?')">Delete</button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
