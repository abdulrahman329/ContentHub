<x-app-layout>
    <!-- Header Section for the "Edit Category" Page -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            {{ __('Edit Category') }}
        </h2>
    </x-slot>

    <div class="container mx-auto px-8 py-12">
        <!-- Main Form Container -->
        <div class="bg-gray-800 p-8 rounded-lg shadow-lg">
            <h3 class="text-2xl text-white mb-4">Edit Category</h3>

            @if(Auth::user()->role == 'admin')

            <!-- Display Success Message if Category is Updated Successfully -->
            @if (session('success'))
                <div class="bg-green-500 text-white p-4 mb-6 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Category Edit Form -->
            <!-- The form will update the category when submitted -->
            <form action="{{ route('categories.update', $category->id) }}" method="POST">
                @csrf <!-- CSRF Token for security -->
                @method('PUT') <!-- Method Spoofing for PUT request, as HTML forms only support GET and POST -->

                <!-- Category Name Input Field -->
                <div class="mb-4">
                    <label for="name" class="block text-gray-300 text-sm font-semibold">Category Name</label>
                    <!-- Input for the category name. The value is pre-filled with the current category name -->
                    <input type="text" name="name" id="name" class="w-full p-4 text-gray-300 bg-gray-700 border rounded-md" placeholder="Enter category name" value="{{ old('name', $category->name) }}" required>
                    
                    <!-- Display Validation Errors if Any -->
                    @error('name')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button to Update the Category -->
                <button type="submit" class="bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-800 w-full">Update Category</button>
            </form>
        </div>
        @else
        <p class='text-white'>You don't have the authority, you have to be an admin</p>
        @endif
    </div>
</x-app-layout>
