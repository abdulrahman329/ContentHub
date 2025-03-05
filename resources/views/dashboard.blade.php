<x-app-layout>
    <!-- Header Section: Displays the Dashboard title -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }} <!-- This is the header of the page -->
        </h2>
    </x-slot>

    <div class="py-12">
        <!-- Main Container for the page -->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Welcome Message Section -->
            <div class="mb-8 text-center">
                <p class="text-2xl font-bold dark:text-white p-2">
                    {{ __("Welcome to the ContentHub ") }} <!-- Display a welcome message -->
                </p>
                <p class="text-2xl font-bold dark:text-white p-2">
                    {{Auth::user()->name }} <!-- Display the name of the currently authenticated user -->
                </p>
            </div>
            
            <!-- Main content box with action buttons -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-xl">
                <div class="p-8 text-gray-900 dark:text-gray-100">
                    <!-- Logged In Status Message -->
                    <p class="text-2xl font-bold mb-6 text-center text-gray-200">
                        {{ __("You're logged in!") }} <!-- Confirmation that the user is logged in -->
                    </p>

                    <!-- Action buttons grid: Options for the user to interact with -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <!-- News Button -->
                        <a href="{{ route('News.index') }}" class="flex items-center justify-center bg-blue-600 text-white p-6 rounded-xl shadow-lg hover:bg-blue-800 transform hover:scale-105 transition-all duration-200 ease-in-out">
                            <span class="text-xl font-semibold">Go to News Page</span>
                        </a>

                        <!-- Posts Button -->
                        <a href="{{ route('posts.index') }}" class="flex items-center justify-center bg-blue-600 text-white p-6 rounded-xl shadow-lg hover:bg-blue-800 transform hover:scale-105 transition-all duration-200 ease-in-out">
                            <span class="text-xl font-semibold">Go to Posts Page</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
