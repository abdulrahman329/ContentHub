<x-app-layout>

    {{-- HEADER --}}
    <x-slot name="header">
        <span class="text-gray-900 dark:text-white">
            {{ __('Create Categories') }}
        </span>
    </x-slot>

    {{-- SUCCESS MESSAGE --}}
    @if(session('success'))
        <x-ui.alert>
            {{ session('success') }}
        </x-ui.alert>
    @endif

    {{-- CREATE CATEGORY --}}
    <div class="bg-white dark:bg-gray-900
                border border-gray-200 dark:border-gray-800
                rounded-3xl p-8 shadow-sm mb-8 transition">

        <h3 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">
            Create Category
        </h3>

        <x-category.form/>

    </div>
</x-app-layout>