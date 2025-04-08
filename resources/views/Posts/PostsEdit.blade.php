<x-app-layout>
    <!-- Header section for the page, sets the title as "Edit Post" -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            {{ __('Edit Post') }}
        </h2>
    </x-slot>

    <div class="container mx-auto px-4 py-12">
        <!-- Page Title: Display "Edit Post" at the center of the page -->  
        <h1 class="text-3xl font-bold my-6 text-center text-white">Edit Post</h1>

        @if(Auth::id() === $post->user_id || Auth::user()->hasRole('admin'))

        <!-- Form for editing the post -->
        <form method="POST" action="{{ route('posts.update', $post->id) }}" enctype="multipart/form-data" class="bg-gray-800 p-6 rounded-lg shadow-md">
            <!-- CSRF protection token to secure the form submission -->
            @csrf
            <!-- Method spoofing for PUT request as HTML forms only support GET and POST -->
            @method('PUT')

            <!-- Title Input Field -->
            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-gray-300">Title</label>
                <!-- Input field for the title with old input value or current post title -->
                <input type="text" name="title" id="title" value="{{ old('title', $post->title) }}" class="mt-1 block w-full px-3 py-2 border border-gray-600 rounded-md shadow-sm bg-gray-700 text-gray-300" required>
            </div>

            <!-- Content Textarea Field -->
            <div class="mb-4">
                <label for="content" class="block text-sm font-medium text-gray-300">Content</label>
                <!-- Textarea for the post content with old input value or current post content -->
                <textarea name="content" id="content" class="mt-1 block w-full px-3 py-2 border border-gray-600 rounded-md shadow-sm bg-gray-700 text-gray-300" required>{{ old('content', $post->content) }}</textarea>
            </div>

            <!-- Category Dropdown Select Field -->
            <div class="mb-4">
                <label for="category_name" class="block text-sm font-medium text-gray-300">Category</label>
                <!-- Dropdown to select the category of the post -->
                <select name="category_id" id="category_name" class="mt-1 block w-full px-3 py-2 border border-gray-600 rounded-md shadow-sm bg-gray-700 text-gray-300" required>
                    <!-- Loop through categories to create the dropdown options dynamically -->
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">
                            <!-- If the category ID matches the old value or current post's category, set it as selected -->
                            @if($category->id == old('category_id', $post->category_id)) selected @endif
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Image Upload Field -->
            <div class="mb-4">
                <label for="image" class="block text-sm font-medium text-gray-300">Image</label>
                <!-- Input for file upload to change or add an image to the post -->
                <input type="file" name="image" id="image" class="mt-1 block w-full px-3 py-2 border border-gray-600 rounded-md shadow-sm bg-gray-700 text-gray-300">
            </div>

            <!-- Submit Button -->
            <div class="text-center">
                <button type="submit" class="mt-4 bg-yellow-500 hover:bg-yellow-700 text-black font-bold py-2 px-4 rounded-md transform hover:scale-105 transition-all duration-200 ease-in-out">
                    <!-- Button text changes to "Update Post" -->
                    Update Post
                </button>
            </div>
        </form>
        @else
        <p class='text-white text-2xl font-bold my-6 text-center'>You don't have the authority, you have to be an admin or the Owner </p>
        @endif
    </div>
</x-app-layout>
