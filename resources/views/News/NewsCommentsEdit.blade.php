<x-app-layout>
    <!-- Header section displaying 'Edit Comment' -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            {{ __('Edit Comment') }}
        </h2>
    </x-slot>

    <!-- Main content container with padding -->
    <div class="container mx-auto px-8 py-12">
        <!-- A box to hold the form, styled with a dark background, padding, rounded corners, and a shadow -->
        <div class="bg-gray-800 p-8 rounded-lg shadow-lg">
            <!-- Form for editing the comment -->
            <form action="{{ route('news_comments.update', $comment->id) }}" method="POST" class="space-y-4">
                <!-- CSRF token to protect the form against cross-site request forgery attacks -->
                @csrf
                <!-- The @method('PUT') directive specifies that this form should use the PUT HTTP method for updating an existing resource -->
                @method('PUT') 

                <!-- Textarea for editing the comment content -->
                <textarea name="content" class="w-full p-4 text-gray-300 bg-gray-700 border rounded-md" rows="4" required>{{ $comment->content }}</textarea>
                <!-- Purpose of this textarea: 
                    - It allows the user to edit the content of an existing comment.
                    - It has a default value filled with the current content of the comment ({{ $comment->content }}).
                    - The 'required' attribute ensures that the user must provide new content before submitting the form.
                    - The `w-full` class makes the textarea take up the full width of its parent container.
                    - The `p-4` class adds padding inside the textarea to make the text easier to read.
                    - The `text-gray-300` class colors the text inside the textarea light gray.
                    - The `bg-gray-700` class makes the background color of the textarea dark gray to match the page design.
                    - The `border` and `rounded-md` add a border with rounded corners for a modern look.
                -->

                <!-- Button to submit the updated comment -->
                <button type="submit" class="bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-800 w-full">
                    Update Comment
                </button>
                <!-- Purpose of the button:
                    - It submits the form, updating the comment with the new content entered in the textarea.
                    - The `bg-blue-600` class gives the button a blue background color, while `text-white` makes the text color white.
                    - The `py-2 px-4` adds padding to the button to make it more clickable.
                    - The `rounded-md` class rounds the corners of the button.
                    - The `hover:bg-blue-800` class changes the button color when the user hovers over it, providing a visual feedback.
                    - The `w-full` class ensures the button spans the full width of the parent container.
                -->
            </form>
        </div>
    </div>
</x-app-layout>
