<x-app-layout>
    <!-- Header section for the page that displays "Create Post" as the page title -->
    <x-slot name="header">    
        {{ __('Create Post') }}
    </x-slot>

    @if(session('success'))
            <x-ui.alert>
                {{ session('success') }}
            </x-ui.alert>
        @endif

        <!-- Page title "Create a New Post" centered in a large font -->
        <h1 class="text-3xl font-bold my-6 text-center text-gray-900 dark:text-white">Create a New Post</h1>

        @can('create' , App\Models\Post::class)
        <x-article.form :categories="$categories" />
        @endcan
</x-app-layout>