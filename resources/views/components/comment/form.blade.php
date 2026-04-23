<div>
@props([
    'comment' => null,   // إذا موجود = edit
    'parentType',        // post OR news
    'parentId'           // id حق post أو news
])

<form method="POST"
      action="{{ $comment
            ? ($parentType === 'news'
                ? route('news.comments.update', $comment->id)
                : route('posts.comments.update', $comment->id))
            : ($parentType === 'news'
                ? route('news.comments.store', $parentId)
                : route('posts.comments.store', $parentId)) }}"
      class="space-y-4">

    @csrf

    {{-- Edit only --}}
    @if($comment)
        @method('PUT')
    @endif

    <!-- Content -->
    <textarea name="content"
        class="w-full p-4 text-gray-300 bg-gray-700 border rounded-md"
        rows="4"
        placeholder="Write a comment..."
        required>{{ old('content', $comment->content ?? '') }}</textarea>

    @error('content')
        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
    @enderror

    <!-- Button -->
    <button type="submit"
        class="bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-800 w-full">
        {{ $comment ? 'Update Comment' : 'Submit Comment' }}
    </button>
</form>
</div>