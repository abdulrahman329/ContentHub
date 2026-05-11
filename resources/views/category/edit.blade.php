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

    <div class="bg-gray-800 p-8 rounded-lg shadow-lg">
        <h3 class="text-2xl text-white mb-4">Edit Category</h3>
            <x-category.form :category="$category" />
            @else
            <p class='text-white text-2xl font-bold my-6 text-center'>You don't have the authority, you have to be an admin</p>
            @endcan
    </div>
</x-app-layout>
