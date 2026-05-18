<x-app-layout>
    <!-- Header Section for the "Edit Category" Page -->
    <x-slot name="header">    
        {{ __('Edit Category') }}
    </x-slot>

    <!-- Display success message if there's any -->
    @if(session('success'))
        <x-ui.alert>
            {{ session('success') }}
        </x-ui.alert>
    @endif

    <div class="bg-gray-200 dark:bg-gray-900 p-8 rounded-lg shadow-lg">
        <h3 class="text-2xl text-gray-900 dark:text-white mb-4">Edit Category</h3>
            <x-category.form :category="$category" />
    </div>
</x-app-layout>
