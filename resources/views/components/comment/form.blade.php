@props([
    'comment' => null,
    'parentType',
    'parentId'
])

@php
    $modelClass = $parentType === 'news'
        ? \App\Models\News::class
        : \App\Models\Post::class;
@endphp

<form method="POST"
      action="{{ $comment ? route('comments.update', $comment->id) : route('comments.store') }}"
      class="space-y-4">

    @csrf

    @if($comment)
        @method('PUT')
    @endif

    {{-- hidden polymorphic --}}
    <input type="hidden" name="commentable_id" value="{{ $parentId }}">
    <input type="hidden" name="commentable_type" value="{{ $modelClass }}">

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