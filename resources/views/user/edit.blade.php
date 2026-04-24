<x-app-layout>
    <!-- Header section for the page -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            {{ __('Edit User') }}
        </h2>
    </x-slot>

    <div class="container mx-auto px-8 py-12">
        <!-- Display success message if there's any -->
        @if (session('success'))
            <div class="bg-green-500 text-white p-4 mb-6 rounded">
                {{ session('success') }}
            </div>
        @endif

        <!-- Main content area for editing user -->
        <div class="bg-gray-800 p-8 rounded-lg shadow-lg mb-8">
            <h3 class="text-2xl text-white mb-4">Edit User</h3>

            @can('update', $user)
            <x-user.form :user="$user" :roles="$roles" />
            @endcan
        </div>
    </div>
    </div>
    </div>
</x-app-layout>
