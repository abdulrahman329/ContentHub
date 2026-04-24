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

            @can('create', App\Models\Category::class)
            <!-- Form for Creating a New Category -->
            <x-category.form/>
            @endcan
        </div>

            @can('viewAny', App\Models\Category::class)
        <!-- List of Existing Categories -->
        <div class="bg-gray-800 p-8 rounded-lg shadow-lg border border-gray-700 max-w-full">
            <h3 class="text-3xl text-white mb-6">Existing Categories</h3>
            <span class="text-gray-500 italic text-right block">
                if you Cannot delete the category because this category has related posts or news.
            </span>            
            <!-- Loop through the categories and display each one -->
            <ul class="space-y-6">
                @foreach ($categories as $category)
                    <li class="flex justify-between items-center bg-gray-700 p-4 rounded-lg shadow w-full overflow-hidden">
                        <div class="flex-1 max-w-[70%]">
                            <!-- Display the Category Name -->
                            <div class="flex items-center mb-2">
                                <span class="font-medium text-gray-300 mr-2">Category Name:</span>
                                <span class=" text-blue-500 text-lg">{{ $category->name }}</span>
                            </div>
                        </div>

                        @can('update', $category)
                        <!-- Edit and Delete Button Section -->
                        <div class="flex space-x-4 ml-4 min-w-[120px]">
                            <!-- Edit Button: Links to the page where the category can be edited -->
                            <a href="{{ route('categories.edit', $category->id) }}" class="text-yellow-500 hover:text-yellow-700">Edit</a>
                        @endcan

                        @can('delete', $category)
                            <!-- Delete Form: Allows the category to be deleted -->
                            <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="inline-block">
                                @csrf <!-- CSRF Token for security -->
                                @method('DELETE') <!-- Method Spoofing for DELETE HTTP request -->
                                
                                <!-- Delete Button with confirmation prompt -->
                                <button type="submit" class="text-red-600 hover:text-red-500" onclick="return confirm('Are you sure you want to delete this category?')">Delete</button>
                            </form>
                        </div>
                        @else
                            <!-- If the user does not have permission to or delete, we can optionally display a message or simply hide the buttons -->
                            <div class="ml-4 min-w-[120px]">
                                <span class="text-gray-500 italic">Cannot delete</span>
                            </div>
                        @endcan
                    </li>
                @endforeach
            </ul>
            <div class="mt-6">
            {{ $categories->links() }} <!-- Pagination links for categories -->
            </div>
        </div>
        @endcan
    </div>
</x-app-layout>
