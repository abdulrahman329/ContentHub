<x-app-layout>
    <!-- Header Section for "Manage Categories" page -->
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-white leading-tight">
            {{ __('Manage Categories') }}
        </h2>
    </x-slot>

    <div class="container mx-auto px-6 py-12 overflow-hidden">
        <!-- Success Message: This will display a success message when a category is created successfully -->
        @if (session('success'))
            <div class="bg-green-600 text-white p-4 mb-6 rounded-lg shadow-lg">
                {{ session('success') }}
            </div>
        @endif

        <!-- Create Category Form -->
        <div class="bg-gray-800 p-8 rounded-lg shadow-lg mb-8 border border-gray-700 max-w-full">
            <h3 class="text-3xl text-white mb-6">Create Category</h3>

            @if(Auth::user()->role == 'admin')

            <!-- Form for Creating a New Category -->
            <form action="{{ route('categories.store') }}" method="POST">
                @csrf <!-- CSRF Token for security -->
                
                <!-- Category Name Input Field -->
                <div class="mb-6">
                    <label for="name" class="block text-gray-300 text-sm font-medium">Category Name</label>
                    <!-- Input field for category name, it is required -->
                    <input type="text" name="name" id="name" class="w-full p-3 mt-2 border border-gray-600 rounded-md focus:ring-2 focus:ring-indigo-600 bg-gray-700 text-white" placeholder="Enter category name" required value="{{ old('name') }}">
                    
                    <!-- Error Message for Category Name -->
                    @error('name')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button for Creating the Category -->
                <button type="submit" class="bg-indigo-600 text-white py-3 px-6 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-600 w-full">Create Category</button>
            </form>
        </div>

        <!-- List of Existing Categories -->
        <div class="bg-gray-800 p-8 rounded-lg shadow-lg border border-gray-700 max-w-full">
            <h3 class="text-3xl text-white mb-6">Existing Categories</h3>

            <!-- Loop through the categories and display each one -->
            <ul class="space-y-6">
                @foreach ($categories as $category)
                    <li class="flex justify-between items-center bg-gray-700 p-4 rounded-lg shadow w-full overflow-hidden">
                        <div class="flex-1 max-w-[70%]">
                            <!-- Display the Category Name -->
                            <div class="flex items-center mb-2">
                                <span class="font-medium text-gray-300 mr-2">Category Name:</span>
                                <span class="text-white">{{ $category->name }}</span>
                            </div>
                        </div>

                        <!-- Edit and Delete Button Section -->
                        <div class="flex space-x-4 ml-4 min-w-[120px]">
                            <!-- Edit Button: Links to the page where the category can be edited -->
                            <a href="{{ route('categories.edit', $category->id) }}" class="text-yellow-500 hover:text-yellow-700">Edit</a>

                            <!-- Delete Form: Allows the category to be deleted -->
                            <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="inline-block">
                                @csrf <!-- CSRF Token for security -->
                                @method('DELETE') <!-- Method Spoofing for DELETE HTTP request -->
                                
                                <!-- Delete Button with confirmation prompt -->
                                <button type="submit" class="text-red-600 hover:text-red-500" onclick="return confirm('Are you sure you want to delete this category?')">Delete</button>
                            </form>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
        @else
        <p class='text-white'>You don't have the authority, you have to be an admin</p>
        @endif
    </div>
</x-app-layout>
