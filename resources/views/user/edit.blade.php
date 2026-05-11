<x-app-layout>
    <!-- Header section for the page -->
    <x-slot name="header">
        {{ __('Edit User') }}
    </x-slot>

    <!-- Display success message if there's any -->
        @if(session('success'))
            <x-ui.alert>
                {{ session('success') }}
            </x-ui.alert>
        @endif

        <!-- Main content area for editing user -->
        <div class="bg-gray-800 p-8 rounded-lg shadow-lg mb-8">
            <h3 class="text-2xl text-white mb-4">Edit User</h3>
                <x-user.form :user="$user" :roles="$roles" />
        </div>
</x-app-layout>