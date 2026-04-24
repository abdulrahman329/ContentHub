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

            @can('update', $category)

            <!-- Display Success Message if Category is Updated Successfully -->
            @if (session('success'))
                <div class="bg-green-500 text-white p-4 mb-6 rounded">
                    {{ session('success') }}
                </div>
            @endif
            <x-category.form :category="$category" />
            @else
            <p class='text-white text-2xl font-bold my-6 text-center'>You don't have the authority, you have to be an admin</p>
            @endcan
    </div>
</div>
</x-app-layout>
