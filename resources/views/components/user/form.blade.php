@props([
    'user' => null,
    'roles' => []
])

@php
    $isEdit = $user !== null;
    $selectedRole = old('role', $user?->roles?->first()?->name);
@endphp

<x-ui.buttons.actions.form
    action="{{ $isEdit
        ? route('users.update', $user->id)
        : route('users.store') }}"
    enctype="multipart/form-data">

    @csrf
    @if($isEdit)
        @method('PUT')
    @endif

    <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-2xl p-6 space-y-6 shadow-xl transition-colors">

        {{-- TITLE --}}
        <div class="text-center mb-2">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white">
                {{ $isEdit ? 'Update User' : 'Create User' }}
            </h2>
            <p class="text-gray-500 dark:text-gray-400 text-sm">
                {{ $isEdit ? 'Edit user details' : 'Add a new user to system' }}
            </p>
        </div>

        {{-- NAME --}}
        <div>
            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                Name
            </label>

            <input type="text"
                name="name"
                value="{{ old('name', $user->name ?? '') }}"
                placeholder="Enter user name..."
                class="w-full px-4 py-3 rounded-xl bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 text-gray-900 dark:text-gray-200 placeholder-gray-400 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition"
                required>
        </div>

        {{-- EMAIL --}}
        <div>
            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                Email
            </label>

            <input type="email"
                name="email"
                value="{{ old('email', $user->email ?? '') }}"
                placeholder="Enter email..."
                class="w-full px-4 py-3 rounded-xl bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 text-gray-900 dark:text-gray-200 placeholder-gray-400 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition"
                required>
        </div>

        {{-- PASSWORD --}}
        <div>
            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                Password
            </label>

            <input type="password"
                name="password"
                placeholder="{{ $isEdit ? 'Leave empty to keep password' : 'Enter password' }}"
                class="w-full px-4 py-3 rounded-xl bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 text-gray-900 dark:text-gray-200 placeholder-gray-400 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition"
                {{ $isEdit ? '' : 'required' }}>
        </div>

        {{-- ROLE --}}
        <div>
            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                Role
            </label>

            <select name="role"
                class="w-full px-4 py-3 rounded-xl bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 text-gray-900 dark:text-gray-200 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition"
                required>

                @foreach($roles as $role)
                    <option value="{{ $role->name }}"
                        @selected($selectedRole == $role->name)>
                        {{ $role->name }}
                    </option>
                @endforeach

            </select>

            @if($isEdit)
                <p class="text-gray-500 dark:text-gray-400 text-xs mt-2">
                    Current:
                    <span class="text-blue-500 font-semibold">
                        {{ $user->roles->first()?->name ?? 'No role' }}
                    </span>
                </p>
            @endif
        </div>

        {{-- IMAGE --}}
        <div>
            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                Profile Image
            </label>

            <input type="file"
                name="image"
                class="w-full px-3 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-xl text-gray-600 dark:text-gray-400 file:bg-gray-100 dark:file:bg-gray-900 file:text-gray-800 dark:file:text-gray-200 file:border-0 file:px-4 file:py-2 file:rounded-lg hover:file:bg-gray-200 dark:hover:file:bg-gray-700 transition">

            @if($isEdit && $user->image)
                <div class="mt-4 flex justify-start">
                    <img src="{{ $user->image_url }}"
                        class="w-20 h-20 rounded-full object-cover border border-gray-300 dark:border-gray-700">
                </div>
            @endif
        </div>

        {{-- BUTTON --}}
        <div class="flex justify-center pt-2">
            <x-ui.buttons.variants
                :variant="$isEdit ? 'update' : 'create'">
                {{ $isEdit ? 'Update User' : 'Create User' }}
            </x-ui.buttons.variants>
        </div>
    </div>
</x-ui.buttons.actions.form>