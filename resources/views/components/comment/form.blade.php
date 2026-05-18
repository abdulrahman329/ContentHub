@props([
    'comment' => null,
    'parentId'
])

<form method="POST"
      action="{{ $comment 
            ? route('comments.update', $comment->id) 
            : route('comments.store') }}"
      class="space-y-4">

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

    <!-- Button -->
    <button type="submit"
        class="bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-800 w-full">
        {{ $comment ? 'Update Comment' : 'Submit Comment' }}
    </button>

</form>