<x-app-layout>
    <!-- Header section for the page, sets the title as "Edit Post" -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            {{ __('Edit Post') }}
        </h2>
    </x-slot>

    <div class="container mx-auto px-4 py-12">
        <!-- Page Title: Display "Edit Post" at the center of the page -->  
        <h1 class="text-3xl font-bold my-6 text-center text-white">Edit Post</h1>

        @can('update', $post)
        <x-article.form type="posts" :model="$post" :categories="$categories" />
        @else
        <p class='text-white text-2xl font-bold my-6 text-center'>You don't have the authority, you have to be an admin or the Owner </p>
        @endcan
    </div>
</x-app-layout>
