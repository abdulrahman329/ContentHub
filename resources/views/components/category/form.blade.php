@props([
    'category' => null
])

<x-ui.buttons.actions.form
    :action="$category
        ? route('categories.update', $category->id)
        : route('categories.store')"
    
    :method="$category ? 'PUT' : 'POST'"

      class="space-y-5">

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

    {{-- BUTTON --}}
    <div class="flex justify-center pt-2">
        <x-ui.buttons.variants
            :variant="$category ? 'update' : 'create'">
                {{ $category ? 'Update Category' : 'create Category' }}
        </x-ui.buttons.variants>
    </div>
</x-ui.buttons.actions.form>