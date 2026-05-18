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
                        class="group relative overflow-hidden rounded-2xl p-6
       
       bg-gray-100/80 dark:bg-gray-900/80
       backdrop-blur border border-gray-200 dark:border-gray-800
       
       hover:border-blue-400/50 dark:hover:border-blue-500/50
       hover:shadow-[0_0_25px_rgba(59,130,246,0.15)]
       
       transition-all duration-300 hover:-translate-y-1">

                            <div class="flex flex-col items-center text-center">

                                <!-- ICON -->
                                <div class="text-4xl mb-3 transition-transform duration-300 group-hover:scale-110">
                                    📝
                                </div>

                                <!-- TITLE -->
                                <span class="text-lg font-bold">
                                    Go to Posts
                                </span>

                                <!-- DESC -->
                                <p class="text-sm mt-1 text-gray-500 dark:text-gray-400">
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