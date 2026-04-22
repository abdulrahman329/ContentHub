<x-app-layout>
    <!-- Header section displaying 'Edit Comment' -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            {{ __('Edit Comment') }}
        </h2>
    </x-slot>

    <!-- Main container that holds the entire form -->
    <div class="container mx-auto px-4 py-12">
        <!-- Page Title: This is the main title displayed at the top of the form -->
        <h1 class="text-3xl font-bold my-6 text-center text-white">Edit comment</h1>

    @can('update', $comment)

    <!-- Main content container with padding -->
    <div class="container mx-auto px-8 py-12">
        <!-- A box to hold the form, styled with a dark background, padding, rounded corners, and a shadow -->
        <div class="bg-gray-800 p-8 rounded-lg shadow-lg">
            <!-- Form for editing the comment -->
            <form action="{{ route('news.comments.update', $comment->id) }}" method="POST" class="space-y-4">
                <!-- CSRF token to protect the form against cross-site request forgery attacks -->
                @csrf
                <!-- The @method('PUT') directive specifies that this form should use the PUT HTTP method for updating an existing resource -->
                @method('PUT') 

                <!-- Textarea for editing the comment content -->
                <textarea name="content" class="w-full p-4 text-gray-300 bg-gray-700 border rounded-md" rows="4" required>{{ $comment->content }}</textarea>

                <!-- Button to submit the updated comment -->
                <button type="submit" class="bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-800 w-full">
                    Update Comment
                </button>
            </form>
        </div>
        @endcan
    </div>            

</x-app-layout>
