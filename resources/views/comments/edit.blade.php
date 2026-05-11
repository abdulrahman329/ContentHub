<x-app-layout>
    <x-slot name="header">    
        {{ __('Edit Comment') }}
    </x-slot>
    
    @if(session('success'))
            <x-ui.alert>
                {{ session('success') }}
            </x-ui.alert>
        @endif

        <h1 class="text-3xl font-bold my-6 text-center text-white">
            Edit Comment
        </h1>

        <div class="bg-gray-800 p-8 rounded-lg shadow-lg">

            <x-comment.form
                :comment="$comment"
                :parentId="$comment->commentable_id"
            />
        </div>
</x-app-layout>