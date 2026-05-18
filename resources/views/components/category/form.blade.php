@props([
    'category' => null
])

<form method="POST"
      action="{{ $category 
            ? route('categories.update', $category->id) 
            : route('categories.store') }}">

    @csrf

    @if($category)
        @method('PUT')
    @endif

    {{-- INPUT --}}
    <div>

        <label class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-300">
            Category Name
        </label>

        <input type="text"
               name="name"
               value="{{ old('name', $category->name ?? '') }}"
               class="w-full px-5 py-4 rounded-2xl
                      bg-gray-100 dark:bg-gray-800
                      border border-gray-300 dark:border-gray-700
                      text-gray-900 dark:text-gray-200
                      placeholder-gray-500 dark:placeholder-gray-400
                      focus:outline-none
                      focus:ring-2                       
                      focus:border-blue-500
                      transition"
               placeholder="Enter category name..."
               required>

        @error('name')
            <p class="text-red-500 text-xs mt-2">
                {{ $message }}
            </p>
        @enderror
    </div>

    <button class="bg-blue-600 text-white py-2 px-4 rounded-md w-full">
        {{ $category ? 'Update Category' : 'Create Category' }}
    </button>
</form>
