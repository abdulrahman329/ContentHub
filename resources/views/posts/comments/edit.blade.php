<x-app-layout>
    <!-- Header for the page -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            <!-- Title of the page that will display "Edit Comment" -->
            {{ __('Edit Comment') }}
        </h2>
    </x-slot>

    <!-- Main container that holds the entire form -->
    <div class="container mx-auto px-4 py-12">
        <!-- Page Title: This is the main title displayed at the top of the form -->
        <h1 class="text-3xl font-bold my-6 text-center text-white">Edit comment</h1>

    @can('update', $comment)

    <div class="container mx-auto px-8 py-12">
        <!-- Form container with padding, background color, and rounded corners -->
        <div class="bg-gray-800 p-8 rounded-lg shadow-lg">
        <x-comment.form :comment="$comment" parentType="post" :parentId="$post->id" />
        @else
        <p class='text-white text-2xl font-bold my-6 text-center'>You don't have the authority, you have to be an admin or the Owner </p>
        @endcan
        </div>
    </div>
</x-app-layout>
