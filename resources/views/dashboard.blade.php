<x-app-layout>
    <!-- Header -->
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Dashboard') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-100 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Welcome Card -->
            <div class="mb-8 text-center bg-white dark:bg-gray-800 shadow-md rounded-2xl p-8">
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 dark:text-white mb-2">
                    {{ __("Welcome to ContentHub") }}
                </h1>

                <p class="text-lg text-gray-600 dark:text-gray-300">
                    {{ Auth::user()->name }}
                </p>
            </div>

            <!-- Main Card -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl rounded-2xl">

                <div class="p-8">

                    <!-- Status -->
                    <div class="text-center mb-8">
                        <h3 class="text-xl font-semibold text-gray-700 dark:text-gray-200">
                            {{ __("You're logged in!") }}
                        </h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                            Manage your content from the dashboard below
                        </p>
                    </div>

                    <!-- Actions -->
                    <div class=" w-full grid grid-cols-1 ">

                        <!-- Posts -->
                        <a href="{{ route('posts.index') }}"
                           class="group bg-blue-700 hover:bg-blue-900 text-white rounded-xl p-6 shadow-md transition transform hover:-translate-y-1 hover:shadow-xl">

                            <div class="flex flex-col items-center text-center">
                                <div class="text-4xl mb-3">📝</div>
                                <span class="text-lg font-semibold group-hover:scale-105 transition">
                                    Go to Posts
                                </span>
                                <p class="text-sm text-blue-100 mt-1">
                                    Create & manage posts
                                </p>
                            </div>
                        </a>

                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>