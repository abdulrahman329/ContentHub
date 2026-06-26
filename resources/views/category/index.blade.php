<x-app-layout>

{{-- HEADER --}}
    <x-slot name="header">
        <span class="text-gray-900 dark:text-white">
            {{ __('Manage Categories') }}
        </span>
    </x-slot>

{{-- EXISTING CATEGORIES --}}
    <div class="bg-white dark:bg-gray-900
                border border-gray-200 dark:border-gray-800
                rounded-3xl p-6 shadow-sm transition">

                <div class="flex justify-center pt-2">
            <x-ui.buttons.actions.link href="{{ route('categories.create') }}">
                    <x-ui.buttons.variants variant="create">
                        Create Categories
                    </x-ui.buttons.variants>
                </x-ui.buttons.actions.link>
        </div>

        {{-- TOP --}}
        <div class="flex items-center justify-between mb-8">

            <h3 class="text-2xl font-bold text-gray-900 dark:text-white">
                Existing Categories
            </h3>

            <div class="text-sm text-gray-500 dark:text-gray-400">
                Total:
                <span class="font-semibold text-gray-800 dark:text-gray-200">
                    {{ $categories->total() }}
                </span>
            </div>

        </div>

        {{-- LIST --}}
        <ul class="space-y-5">

            @forelse ($categories as $category)

                <li class="flex flex-col md:flex-row md:items-center md:justify-between
                           gap-5
                           bg-gray-50 dark:bg-gray-800/70
                           border border-gray-200 dark:border-gray-700
                           rounded-2xl p-5 transition hover:shadow-md">

                    {{-- LEFT --}}
                    <div class="flex-1 overflow-hidden">

                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">
                            Category Name
                        </p>

                        <h4 class="text-xl font-semibold
                                   text-gray-900 dark:text-white
                                   break-words">
                            {{ $category->name }}
                        </h4>

                    </div>

                    {{-- ACTIONS --}}
                    <div class="flex items-center gap-3 shrink-0">

                        @can('update', $category)

                            <x-ui.buttons.actions.link
                                href="{{ route('categories.edit', $category->id) }}">

                                <x-ui.buttons.variants variant="warning">
                                    Edit
                                </x-ui.buttons.variants>

                            </x-ui.buttons.actions.link>

                        @endcan

                        @can('delete', $category)

                            <x-ui.buttons.actions.form
                                action="{{ route('categories.destroy', $category->id) }}"
                                method="DELETE">
                                    <x-ui.buttons.variants variant="danger">
                                        Delete
                                    </x-ui.buttons.variants>
                            </x-ui.buttons.actions.form>
                        @endcan
                    </div>
                </li>
            @empty
                <x-ui.empty-state message="No categories found."/>
            @endforelse
        </ul>
        {{-- PAGINATION --}}
        <div class="mt-8">
            {{ $categories->links() }}
        </div>
    </div>
</x-app-layout>