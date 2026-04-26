<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            {{ __('Edit Comment') }}
        </h2>
    </x-slot>

    <div class="container mx-auto px-4 py-12">

        <h1 class="text-3xl font-bold my-6 text-center text-white">
            Edit Comment
        </h1>

        @can('update', $comment)

        <div class="bg-gray-800 p-8 rounded-lg shadow-lg">

            <x-comment.form
                :comment="$comment"
                :parentType="$comment->commentable_type === App\Models\News::class ? 'news' : 'post'"
                :parentId="$comment->commentable_id"
            />

        </div>

        @else

        <p class="text-white text-2xl font-bold my-6 text-center">
            You don't have permission to edit this comment
        </p>

        @endcan

    </div>

</x-app-layout>