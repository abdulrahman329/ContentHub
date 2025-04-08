<x-app-layout>
    <!-- Header for the page -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            <!-- Title of the page that will display "Edit Comment" -->
            {{ __('Edit Comment') }}
        </h2>
    </x-slot>

    <div class="container mx-auto px-8 py-12">
        <!-- Form container with padding, background color, and rounded corners -->
        <div class="bg-gray-800 p-8 rounded-lg shadow-lg">
            <!-- Start of the form. It uses POST method to submit to the 'posts_comments.update' route with the comment's ID -->
            <form action="{{ route('posts_comments.update', $comment->id) }}" method="POST" class="space-y-4">
                <!-- CSRF token for protection against Cross-Site Request Forgery attacks -->
                @csrf
                <!-- Method spoofing to simulate a PUT request, as HTML forms only support GET and POST -->
                @method('PUT')

                <!-- Textarea for editing the comment content -->
                <div>
                    <label for="content" class="block text-sm text-gray-300 font-semibold mb-2">Comment Content</label>
                    <!-- Pre-fill the textarea with the current comment's content -->
                    <textarea name="content" id="content" class="w-full p-4 text-gray-300 bg-gray-700 border rounded-md" rows="4" required autofocus>{{ $comment->content }}</textarea>
                    <!-- Display error message for 'content' field if validation fails -->
                    @error('content')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit button for updating the comment -->
                <button type="submit" class="bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-800 w-full">
                    <!-- Button text to submit the form -->
                    Update Comment
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
