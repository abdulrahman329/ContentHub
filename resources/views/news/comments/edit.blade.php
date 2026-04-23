<x-app-layout>
    <!-- Header section displaying 'Edit Comment' -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            {{ __('Edit Comment') }}
        </h2>
    </x-slot>

    <!-- Main container that holds the entire form -->
    <div class="container mx-auto px-4 py-12">
        <!-- Page Title: This is the main title displayed at the top of the form -->
        <h1 class="text-3xl font-bold my-6 text-center text-white">Edit comment</h1>

    @can('update', $comment)

    <!-- Main content container with padding -->
    <div class="container mx-auto px-8 py-12">
        <!-- A box to hold the form, styled with a dark background, padding, rounded corners, and a shadow -->
        <div class="bg-gray-800 p-8 rounded-lg shadow-lg">
        <x-comment.form :comment="$comment" parentType="news" :parentId="$news->id" />
        </div>
        @endcan
    </div>            

</x-app-layout>
