<x-app-layout>
    <!-- Header Section: This is the header area where the page title 'Edit News' is displayed -->
    <x-slot name="header">
        <!-- Display the 'Edit News' header title -->
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            {{ __('Edit News') }}
        </h2>
    </x-slot>
    <!-- Main container that holds the entire form -->
    <div class="container mx-auto px-4 py-12">
        <!-- Page Title: This is the main title displayed at the top of the form -->
        <h1 class="text-3xl font-bold my-6 text-center text-white">Edit News</h1>

    @can('update', $news)
    <x-article.form type="news" :model="$news" :categories="$categories" />
        @else
        <p class='text-white text-2xl font-bold my-6 text-center'>You don't have the authority, you have to be an admin or the Owner </p>
        @endcan
    </div>
</x-app-layout>
