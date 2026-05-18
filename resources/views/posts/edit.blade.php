<x-app-layout>
    <!-- Header section for the page, sets the title as "Edit Post" -->
    <x-slot name="header">    
        {{ __('Edit Post') }}
    </x-slot>

    @if(session('success'))
            <x-ui.alert>
                {{ session('success') }}
            </x-ui.alert>
        @endif

        <!-- Page Title: Display "Edit Post" at the center of the page -->  
        <h1 class="text-3xl font-bold my-6 text-center text-gray-900 dark:text-white">Edit Post</h1>

        @can('update', $post)
        <x-article.form :model="$post" :categories="$categories" />
        @endcan
</x-app-layout>