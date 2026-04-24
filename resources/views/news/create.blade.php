<x-app-layout>
    <x-slot name="header">
        <!-- Header section displaying 'Create News' -->
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            {{ __('Create News') }}
        </h2>
    </x-slot>

    <!-- Main content container -->
    <div class="container mx-auto px-4 py-12">
        <!-- Page Title: This displays the main title of the page -->
        <h1 class="text-3xl font-bold my-6 text-center text-white">Create a New News</h1>

        @can('create', App\Models\News::class)
        <x-article.form type="news" :categories="$categories" />
        @else
    <p class='text-white text-2xl font-bold my-6 text-center'>You don't have the authority, you have to be an admin or writer </p>
@endcan
</div>
</x-app-layout>
