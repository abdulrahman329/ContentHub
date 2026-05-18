<x-app-layout>

    {{-- HEADER --}}
    <x-slot name="header">
        <span class="text-gray-900 dark:text-white">
            {{ __('Manage Categories') }}
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

    {{-- EXISTING CATEGORIES --}}
    <div class="bg-white dark:bg-gray-900
                border border-gray-200 dark:border-gray-800
                rounded-3xl p-8 shadow-sm transition">

        {{-- TOP --}}
        <div class="flex items-center justify-between mb-8">

            <h3 class="text-3xl font-bold text-gray-900 dark:text-white">
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
                            <!-- Edit Button: Links to the page where the category can be edited -->
                            <x-ui.buttons.edit 
                                href="{{ route('categories.edit', $category->id) }}">
                                Edit
                            </x-ui.buttons.edit>
                        @endcan

                        @can('delete', $category)
                            <!-- Delete Form: Allows the category to be deleted -->
                            <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="inline-block">
                                @csrf <!-- CSRF Token for security -->
                                @method('DELETE') <!-- Method Spoofing for DELETE HTTP request -->
                                
                                <!-- Delete Button with confirmation prompt -->
                                <button type="submit" class="text-red-600 hover:text-red-500" onclick="return confirm('Are you sure you want to delete this category?')">Delete</button>
                            </form>
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