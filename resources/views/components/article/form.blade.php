@props([
    'model' => null,
    'categories'
])

@php
    $isEdit = $model !== null;
@endphp

<form method="POST"
      action="{{ $isEdit
            ? route('posts.update', $model->id)
            : route('posts.store') }}"
      enctype="multipart/form-data"
      class="bg-gray-800 p-6 rounded-lg shadow-md">

    @csrf

    @if($isEdit)
        @method('PUT')
    @endif

    <!-- Title -->
    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-300">Title</label>
        <input type="text" name="title"
            value="{{ old('title', $model->title ?? '') }}"
            class="mt-1 block w-full px-3 py-2 border border-gray-600 rounded-md bg-gray-700 text-gray-300"
            required>
    </div>

    <!-- Content -->
    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-300">Content</label>
        <textarea name="content"
            rows="4"
            class="mt-1 block w-full px-3 py-2 border border-gray-600 rounded-md bg-gray-700 text-gray-300"
            required>{{ old('content', $model->content ?? '') }}</textarea>
    </div>

    <!-- Category -->
    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-300">Category</label>
        <select name="category_id"
            class="mt-1 block w-full px-3 py-2 border border-gray-600 rounded-md bg-gray-700 text-gray-300"
            required>

            @foreach($categories as $category)
                <option value="{{ $category->id }}"
                    {{ old('category_id', $model->category_id ?? '') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>

        @if($model)
            <div class="mt-2 text-gray-300">
                Current category:
                <span class="text-blue-400 font-bold">
                    {{ $model->category->name }}
                </span>
            </div>
        @endif
    </div>

    <!-- Type -->
    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-300">Type</label>

        <select name="type"
            class="mt-1 block w-full px-3 py-2 border border-gray-600 rounded-md bg-gray-700 text-gray-300"
            required>

         <option value="post"
            @selected(old('type', $model->type ?? 'post') == 'post')>
            Post
        </option>

        <option value="news"
            @selected(old('type', $model->type ?? '') == 'news')>
            News
        </option>

        </select>
    </div>

    <!-- Image -->
    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-300">Image</label>
        <input type="file" name="image"
            class="mt-1 block w-full px-3 py-2 border border-gray-600 rounded-md bg-gray-700 text-gray-300">

        @if($isEdit && $model->image)
            <img src="{{ filter_var($model->image, FILTER_VALIDATE_URL)
                ? $model->image
                : asset('storage/'.$model->image) }}"
                class="w-32 h-32 object-cover rounded mt-3">
        @endif
    </div>

    <!-- Button -->
    <div class="text-center">
        <button type="submit"
            class="px-6 py-2 rounded font-bold
            {{ $isEdit ? 'bg-yellow-500 text-black hover:bg-yellow-700' : 'bg-blue-600 text-white hover:bg-blue-800' }}">
            {{ $isEdit ? 'Update Post' : 'Create Post' }}
        </button>
    </div>
</form>