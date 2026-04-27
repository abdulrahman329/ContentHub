@props([
    'comment' => null,
    'parentType',
    'parentId'
])

@php
    $modelClass = match ($parentType) {
        'news' => \App\Models\News::class,
        default => \App\Models\Post::class,
    };
@endphp

<form method="POST"
      action="{{ $comment 
            ? route('comments.update', $comment->id) 
            : route('comments.store') }}"
      class="space-y-4">

    @csrf

    @if($comment)
        @method('PUT')
    @endif

    {{-- Polymorphic relation --}}
    <input type="hidden" name="commentable_id" value="{{ $parentId }}">
    <input type="hidden" name="commentable_type" value="{{ $modelClass }}">

    <!-- Content -->
    <textarea name="content"
        class="w-full p-4 text-gray-300 bg-gray-700 border border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
        rows="4"
        placeholder="Write a comment..."
        required>{{ old('content', $comment->content ?? '') }}</textarea>

    @error('content')
        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
    @enderror

    <!-- Button -->
    <button type="submit"
        class="bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-800 transition w-full">
        {{ $comment ? 'Update Comment' : 'Submit Comment' }}
    </button>

</form>