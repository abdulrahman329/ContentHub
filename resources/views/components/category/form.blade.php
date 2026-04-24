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

    <div class="mb-4">
        <label class="block mb-2 text-gray-300 text-sm font-semibold">
            Category Name
        </label>

        <input type="text"
               name="name"
               class="w-full p-4 text-gray-300 bg-gray-700 border rounded-md"
               value="{{ old('name', $category->name ?? '') }}"
               required>

        @error('name')
            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
        @enderror
    </div>

    <button class="bg-blue-600 text-white py-2 px-4 rounded-md w-full">
        {{ $category ? 'Update Category' : 'Create Category' }}
    </button>
</form>
