<x-app-layout>
    <!-- Header section for the page that displays "Create Post" as the page title -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            {{ __('Create Post') }}
        </h2>
    </x-slot>

    <div class="container mx-auto px-4 py-12">
        <!-- Page title "Create a New Post" centered in a large font -->
        <h1 class="text-3xl font-bold my-6 text-center text-white">Create a New Post</h1>

        @can('create' , App\Models\Post::class)
        <x-article.form :categories="$categories" />
        @else
        <p class='text-white text-2xl font-bold my-6 text-center'>You don't have the authority, you have to be an admin or writer </p>
        @endcan
    </div>
</x-app-layout>
