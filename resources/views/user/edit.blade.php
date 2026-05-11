<x-app-layout>
    <!-- Header section for the page -->
    <x-slot name="header">
        {{ __('Edit User') }}
    </x-slot>

                {{ session('success') }}
        @endif

        <!-- Main content area for editing user -->
        <div class="bg-gray-800 p-8 rounded-lg shadow-lg mb-8">
            <h3 class="text-2xl text-white mb-4">Edit User</h3>

            @can('update', $user)
            <x-user.form :user="$user" :roles="$roles" />
            @endcan
        </div>
</x-app-layout>