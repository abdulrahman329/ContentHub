<x-app-layout>
    <!-- Header section for the page that displays "Create Post" as the page title -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            {{ __('Create Post') }}
        </h2>
    </x-slot>

    <div class="container mx-auto px-4 py-12">
        <!-- Page title "Create a New Post" centered in a large font -->
        <h1 class="text-3xl font-bold my-6 text-center text-white">Create a New Post</h1>

        @if(Auth::user()->hasRole('writer') || Auth::user()->hasRole('admin'))

        <!-- The form to create a new post -->
        <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data" class="bg-gray-800 p-6 rounded-lg shadow-md">
            <!-- CSRF token for security; ensures the form request is valid -->
            @csrf

            <!-- Title input field for the post -->
            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-gray-300">Title</label>
                <!-- Text input for the title of the post, required field -->
                <input type="text" name="title" id="title" class="mt-1 block w-full px-3 py-2 border border-gray-600 rounded-md shadow-sm bg-gray-700 text-gray-300" required>
            </div>

            <!-- Content textarea field for the post -->
            <div class="mb-4">
                <label for="content" class="block text-sm font-medium text-gray-300">Content</label>
                <!-- Textarea for the post's content, required field -->
                <textarea name="content" id="content" class="mt-1 block w-full px-3 py-2 border border-gray-600 rounded-md shadow-sm bg-gray-700 text-gray-300" rows="4" required></textarea>
            </div>

            <!-- Category dropdown field to choose the category for the post -->
            <div class="mb-4">
                <label for="category_id" class="block text-sm font-medium text-gray-300">Category</label>
                <select name="category_id" id="category_id" class="mt-1 block w-full px-3 py-2 border border-gray-600 rounded-md shadow-sm bg-gray-700 text-gray-300" required>
                    <!-- Loop through all available categories and display them as options in the dropdown -->
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Image upload field for the post's image -->
            <div class="mb-4">
                <label for="image" class="block text-sm font-medium text-gray-300">Image</label>
                <!-- Input field for uploading an image file -->
                <input type="file" name="image" id="image" class="mt-1 block w-full px-3 py-2 border border-gray-600 rounded-md shadow-sm bg-gray-700 text-gray-300">
            </div>

            <!-- Hidden input field for the authenticated user's ID (used to associate the post with the user) -->
            <input type="hidden" name="user_id" value="{{ auth()->id() }}">

            <!-- Submit button to create the post -->
            <div class="text-center">
                <button type="submit" class="bg-blue-600 hover:bg-blue-800 hover:scale-105 duration-200 text-white font-bold py-2 px-4 rounded">
                    Create Post
                </button>
            </div>
        </form>
        @else
        <p class='text-white text-2xl font-bold my-6 text-center'>You don't have the authority, you have to be an admin or writer </p>
        @endif
    </div>
</x-app-layout>
