<x-app-layout>
    <!-- Header Section: This is the header area where the page title 'Edit News' is displayed -->
    <x-slot name="header">
        <!-- Display the 'Edit News' header title -->
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            {{ __('Edit News') }}
        </h2>
    </x-slot>

    <!-- Main container that holds the entire form -->
    <div class="container mx-auto px-4 py-12">
        <!-- Page Title: This is the main title displayed at the top of the form -->
        <h1 class="text-3xl font-bold my-6 text-center text-white">Edit News</h1>

        @if(Auth::user()->role == 'writer' || Auth::user()->role == 'admin')

        <!-- Form to update the news article -->
        <form method="POST" action="{{ route('News.update', $News->id) }}" enctype="multipart/form-data" class="bg-gray-800 p-6 rounded-lg shadow-md">
            @csrf <!-- CSRF token for security to prevent CSRF attacks -->
            @method('PUT') <!-- Method Spoofing to specify the HTTP method as PUT for updating the resource -->

            <!-- Title Input Field -->
            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-gray-300">Title</label>
                <input type="text" name="title" id="title" value="{{ old('title', $News->title) }}" class="mt-1 block w-full px-3 py-2 border border-gray-600 rounded-md shadow-sm bg-gray-700 text-gray-300" required>
                <!-- 'value' is pre-filled with the old input value or the current news title using old() helper or $News->title -->
            </div>

            <!-- Content Textarea Field -->
            <div class="mb-4">
                <label for="content" class="block text-sm font-medium text-gray-300">Content</label>
                <textarea name="content" id="content" class="mt-1 block w-full px-3 py-2 border border-gray-600 rounded-md shadow-sm bg-gray-700 text-gray-300" required>{{ old('content', $News->content) }}</textarea>
                <!-- 'old()' retrieves the old content or the current news content, pre-filling the textarea. The content is required to be filled out -->
            </div>

            <!-- Category Dropdown Select Field -->
            <div class="mb-4">
                <label for="category_name" class="block text-sm font-medium text-gray-300">Category</label>
                <select name="category_id" id="category_name" class="mt-1 block w-full px-3 py-2 border border-gray-600 rounded-md shadow-sm bg-gray-700 text-gray-300" required>
                    <!-- Loop through the categories to dynamically create the dropdown options -->
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">
                            <!-- The category that was previously selected will be marked as selected -->
                            @if($category->id == old('category_id', $News->category_id)) selected @endif
                            {{ $category->name }} <!-- Display the category name in the dropdown -->
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Image Upload Field: This allows the user to upload a new image if they want to change the image for the news article -->
            <div class="mb-4">
                <label for="image" class="block text-sm font-medium text-gray-300">Image</label>
                <input type="file" name="image" id="image" class="mt-1 block w-full px-3 py-2 border border-gray-600 rounded-md shadow-sm bg-gray-700 text-gray-300">
                <!-- The 'file' input allows the user to choose a file from their computer to upload -->
            </div>

            <!-- Submit Button: Button to submit the form and update the news article -->
            <div class="text-center">
                <button type="submit" class="mt-4 bg-yellow-500 hover:bg-yellow-700 text-black font-bold py-2 px-4 rounded-md transform hover:scale-105 transition-all duration-200 ease-in-out">
                    Update News
                </button>
                <!-- The button submits the form and updates the news article with the new values -->
            </div>
        </form>
        @else
        <p class='text-white text-2xl font-bold my-6 text-center'>You don't have the authority, you have to be an admin or writer </p>
        @endif
    </div>
</x-app-layout>
