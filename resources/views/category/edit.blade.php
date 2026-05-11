<x-app-layout>
    <!-- Header Section for the "Edit Category" Page -->
    <x-slot name="header">    
        {{ __('Edit Category') }}
    </x-slot>


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
</x-app-layout>
