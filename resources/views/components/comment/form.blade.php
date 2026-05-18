@props([
    'comment' => null,
    'parentId'
])

@php
    $isEdit = $comment !== null;
@endphp

<x-ui.buttons.actions.form
    :action="$isEdit
        ? route('comments.update', $comment->id)
        : route('comments.store')"

    :method="$isEdit ? 'PUT' : 'POST'"

    class="flex items-center gap-2
           bg-white dark:bg-gray-900
           border border-gray-300 dark:border-gray-800
           rounded-md p-2 transition">

    @csrf

    @if($isEdit)
        @method('PUT')
    @endif

    <input type="hidden" name="commentable_id" value="{{ $parentId }}">
    <input type="hidden" name="commentable_type" value="post">

    {{-- INPUT --}}
    <textarea
        name="content"
        rows="1"
        placeholder="Write a comment..."
        class="flex-1 px-2 py-1
               bg-transparent
               text-gray-800 dark:text-gray-200
               placeholder-gray-500 dark:placeholder-gray-400
               text-sm resize-none focus:outline-none"
        required>{{ old('content', $comment->content ?? '') }}</textarea>

    {{-- BUTTON --}}
     <x-ui.buttons.variants
        :variant="$isEdit ? 'comment' : 'comment'">
        {{ $isEdit ? 'Update' : 'Send' }}
    </x-ui.buttons.variants>
</x-ui.buttons.actions.form>