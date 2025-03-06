<x-app-layout>
    <x-slot name="header">
        <!-- Header section displaying 'Create News' -->
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            {{ __('Create News') }}
        </h2>
    </x-slot>

    <!-- Main content container -->
    <div class="container mx-auto px-4 py-12">
        <!-- Page Title: This displays the main title of the page -->
        <h1 class="text-3xl font-bold my-6 text-center text-white">Create a New News</h1>

        @if(Auth::user()->role == 'writer' || Auth::user()->role == 'admin')

        <!-- Form for creating a new news article -->
        <form action="{{ route('News.store') }}" method="POST" enctype="multipart/form-data" class="bg-gray-800 p-6 rounded-lg shadow-md">
            @csrf <!-- CSRF token for form security (prevents cross-site request forgery attacks) -->

            <!-- Title Input Field -->
            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-gray-300">Title</label>
                <!-- Input field for the title of the news article -->
                <input type="text" name="title" id="title" class="mt-1 block w-full px-3 py-2 border border-gray-600 rounded-md shadow-sm bg-gray-700 text-gray-300" required>
                <!-- The 'required' attribute ensures the title must be provided before form submission -->
            </div>

            <!-- Content Textarea Field -->
            <div class="mb-4">
                <label for="content" class="block text-sm font-medium text-gray-300">Content</label>
                <!-- Textarea for the content of the news article -->
                <textarea name="content" id="content" class="mt-1 block w-full px-3 py-2 border border-gray-600 rounded-md shadow-sm bg-gray-700 text-gray-300" rows="4" required></textarea>
                <!-- 'rows' attribute defines the height of the textarea, and 'required' ensures content is provided -->
            </div>

            <!-- Category Dropdown Select Field -->
            <div class="mb-4">
                <label for="category_name" class="block text-sm font-medium text-gray-300">Category</label>
                <!-- Dropdown menu for selecting a category for the news article -->
                <select name="category_id" id="category_name" class="mt-1 block w-full px-3 py-2 border border-gray-600 rounded-md shadow-sm bg-gray-700 text-gray-300" required>
                    <!-- Loop through all categories fetched from the database and create options dynamically -->
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->id }}</option>
                        <!-- Each category's name is displayed, and its ID is passed as the value -->
                    @endforeach
                    <!-- This ensures that only the categories available in the database are listed for selection -->
                </select>
            </div>

            <!-- Image Upload Field -->
            <div class="mb-4">
                <label for="image" class="block text-sm font-medium text-gray-300">Image</label>
                <!-- Input field to upload an image (optional) -->
                <input type="file" name="image" id="image" class="mt-1 block w-full px-3 py-2 border border-gray-600 rounded-md shadow-sm bg-gray-700 text-gray-300">
                <!-- This field allows the user to upload an image related to the news article -->
            </div>

            <!-- Hidden field to pass the user ID automatically -->
            <input type="hidden" name="user_id" value="{{ auth()->id() }}">
            <!-- This hidden input field automatically sends the ID of the currently authenticated user -->
            <!-- This ensures that the news article is associated with the correct user when stored in the database -->

            <!-- Submit Button to create the news article -->
            <div class="text-center">
                <button type="submit" class="bg-blue-600 hover:bg-blue-800 hover:scale-105 duration-200 text-white font-bold py-2 px-4 rounded">
                    Create News
                </button>
                <!-- Button to submit the form and create the news article -->
            </div>
        </form>
        @else
        <p class='text-white text-2xl font-bold my-6 text-center'>You don't have the authority, you have to be an admin or writer </p>
        @endif
    </div>
</x-app-layout>
