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

    {{-- TITLE --}}
    <div>
        <label class="block text-sm font-semibold mb-2
            text-gray-700
            dark:text-gray-300">
            Title
        </label>
        <input type="text"
            name="title"
            value="{{ old('title', $model->title ?? '') }}"
            placeholder="Enter title..."
            class="w-full px-4 py-3 rounded-xl border transition-all duration-200

            bg-gray-50 border-gray-300 text-gray-900 placeholder-gray-400
            focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20

            dark:bg-gray-800 dark:border-gray-700 dark:text-gray-200 dark:placeholder-gray-500"
            required>
    </div>

    {{-- CONTENT --}}
    <div>
        <label class="block text-sm font-semibold mb-2
            text-gray-700
            dark:text-gray-300">
            Content
        </label>

        <textarea
            name="content"
            rows="6"
            placeholder="Write something..."
            class="w-full px-4 py-3 rounded-xl border resize-none transition-all duration-200

            bg-gray-50 border-gray-300 text-gray-900 placeholder-gray-400
            focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20

            dark:bg-gray-800 dark:border-gray-700 dark:text-gray-200 dark:placeholder-gray-500"

            required>{{ old('content', $model->content ?? '') }}
        </textarea>
    </div>

    {{-- CATEGORY + TYPE --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

        {{-- CATEGORY --}}
        <div>
            <label class="block text-sm font-semibold mb-2
                text-gray-700
                dark:text-gray-300">
                Category
            </label>
            <select name="category_id"
                class="w-full px-4 py-3 rounded-xl border transition-all duration-200

                bg-gray-50 border-gray-300 text-gray-900
                focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20

                dark:bg-gray-800 dark:border-gray-700 dark:text-gray-200"

                required>

                @foreach($categories as $category)
                    <option value="{{ $category->id }}"
                        @selected(old('category_id', $model->category_id ?? '') == $category->id)>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- TYPE --}}
        <div>
            <label class="block text-sm font-semibold mb-2
                text-gray-700
                dark:text-gray-300">
                Type
            </label>
            <select name="type"
                class="w-full px-4 py-3 rounded-xl border transition-all duration-200

                bg-gray-50 border-gray-300 text-gray-900
                focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20

                dark:bg-gray-800 dark:border-gray-700 dark:text-gray-200"
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
    </div>

    {{-- IMAGE --}}
    <div>
        <label class="block text-sm font-semibold mb-2
            text-gray-700
            dark:text-gray-300">
            Image
        </label>
        <input type="file"
            name="image"
            class="block w-full text-sm rounded-xl border transition-all duration-200

            bg-gray-50 border-gray-300 text-gray-700
            file:mr-4 file:px-4 file:py-2
            file:border-0 file:rounded-lg
            file:bg-gray-200 file:text-gray-800
            hover:file:bg-gray-300

            dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300
            dark:file:bg-gray-900 dark:file:text-gray-200
            dark:hover:file:bg-gray-700">
        @if($isEdit && $model->image)
            <div class="mt-4">
                <img
                    src="{{ $model->image_url }}"
                    class="w-full max-w-xs h-40 object-cover rounded-xl border
                    border-gray-300
                    dark:border-gray-700">
            </div>
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