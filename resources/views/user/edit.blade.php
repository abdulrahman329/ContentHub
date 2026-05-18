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
            <h3 class="text-2xl dark:text-white text-gray-900  mb-4">Edit User</h3>
                <x-user.form :user="$user" :roles="$roles" />
</x-app-layout>