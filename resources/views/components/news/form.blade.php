<div>
@props([
    'news' => null,
    'categories'
])

<form method="POST"
      action="{{ $news ? route('news.update', $news->id) : route('news.store') }}"
      enctype="multipart/form-data"
      class="bg-gray-800 p-6 rounded-lg shadow-md">

    @csrf

    {{-- if editing--}}
    @if($news)
        @method('PUT')
    @endif

    <!-- Title -->
    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-300">Title</label>
        <input type="text" name="title"
            value="{{ old('title', $news->title ?? '') }}"
            class="mt-1 block w-full px-3 py-2 border border-gray-600 rounded-md bg-gray-700 text-gray-300"
            required>

        @error('title')
            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
        @enderror
    </div>

    <!-- Content -->
    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-300">Content</label>
        <textarea name="content"
            class="mt-1 block w-full px-3 py-2 border border-gray-600 rounded-md bg-gray-700 text-gray-300"
            rows="4"
            required>{{ old('content', $news->content ?? '') }}</textarea>

        @error('content')
            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
        @enderror
    </div>

    <!-- Category -->
    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-300">Category</label>
        <select name="category_id"
            class="mt-1 block w-full px-3 py-2 border border-gray-600 rounded-md bg-gray-700 text-gray-300"
            required>

            @foreach($categories as $category)
                <option value="{{ $category->id }}"
                    {{ old('category_id', $news->category_id ?? '') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>

        {{-- Only appears in edit --}}
        @if($news)
            <div class="mt-2 text-gray-300">
                Current category:
                <span class="text-blue-400 font-bold">
                    {{ $news->category->name }}
                </span>
            </div>
        @endif
    </div>

    <!-- Image -->
    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-300">Image</label>
        <input type="file" name="image"
            class="mt-1 block w-full px-3 py-2 border border-gray-600 rounded-md bg-gray-700 text-gray-300">

            {{-- Only appears in edit --}}
            @if($news && $news->image)
            <div class="mt-3">
                <img src="{{ filter_var($news->image, FILTER_VALIDATE_URL) ? $news->image : asset('storage/'.$news->image) }}"
                     class="w-32 h-32 object-cover rounded">
            </div>
        @endif
    </div>

    <!-- Button -->
    <div class="text-center">
    <button type="submit"
        class="inline-block {{ $news ? 'bg-yellow-500 hover:bg-yellow-700 text-black' : 'bg-blue-600 hover:bg-blue-800 text-white' }}
           font-bold py-2 px-6 rounded transition">
        {{ $news ? 'Update News' : 'Create News' }}
    </button>
</div>
</form>
</div>