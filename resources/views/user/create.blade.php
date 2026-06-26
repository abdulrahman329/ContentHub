<x-app-layout>

    <div class="max-w-7xl mx-auto py-8 space-y-8
                text-gray-900 dark:text-gray-100">

        {{-- HEADER --}}
            <x-slot name="header">    
                {{ __('Create Users') }}
            </x-slot>

        {{-- CREATE USER --}}
        <x-user.form :roles="$roles" />

    </div>
</x-app-layout>