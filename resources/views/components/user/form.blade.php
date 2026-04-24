@props([
'user' => null,
'roles' => []
])

@php
$selectedRole = old('role', $user?->roles?->first()?->name);
@endphp

<form method="POST"
      action="{{ $user 
            ? route('users.update', $user->id) 
            : route('users.store') }}"
      enctype="multipart/form-data">

@csrf
@if($user)
    @method('PUT')
@endif

<!-- Name -->
<div class="mb-6">
    <label class="block text-gray-300 text-sm font-medium">User Name</label>
    <input type="text" name="name"
        class="w-full p-3 mt-2 border border-gray-600 rounded-md focus:ring-2 focus:ring-indigo-600 bg-gray-700 text-white"
        placeholder="Enter User name"
        required
        value="{{ old('name', $user->name ?? '') }}">

    @error('name')
        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
    @enderror
</div>

<!-- Email -->
<div class="mb-6">
    <label class="block text-gray-300 text-sm font-medium">User Email</label>
    <input type="email" name="email"
        class="w-full p-3 mt-2 border border-gray-600 rounded-md focus:ring-2 focus:ring-indigo-600 bg-gray-700 text-white"
        placeholder="Enter User email"
        required
        value="{{ old('email', $user->email ?? '') }}">

    @error('email')
        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
    @enderror
</div>

<!-- Password -->
<div class="mb-6">
    <label class="block text-gray-300 text-sm font-medium">Password</label>
    <input type="password" name="password"
        class="w-full p-3 mt-2 border border-gray-600 rounded-md focus:ring-2 focus:ring-indigo-600 bg-gray-700 text-white"
        placeholder="{{ $user ? 'Leave blank to keep current password' : 'Enter User password' }}"
        {{ $user ? '' : 'required' }}>

    @error('password')
        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
    @enderror
</div>

<!-- Role -->
<div class="mb-6">
    <label class="block text-gray-300 text-sm font-medium">Role</label>
    <select name="role"
        class="w-full p-3 mt-2 border border-gray-600 rounded-md focus:ring-2 focus:ring-indigo-600 bg-gray-700 text-white"
        required>

        @foreach($roles as $role)
            <option value="{{ $role->name }}"
                {{ $selectedRole == $role->name ? 'selected' : '' }}>
                {{ $role->name }}
            </option>
        @endforeach
    </select>

    @error('role')
        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
    @enderror

    @if($user)
        <p class="text-gray-400 text-sm mt-2">
            Current Role:
            <span class="text-blue-400 font-semibold">
                {{ $user->roles->first()?->name ?? 'No role' }}
            </span>
        </p>
    @endif
</div>

<!-- Image -->
<div class="mb-6">
    <label class="block text-gray-300 text-sm font-medium mb-2">Profile Image</label>
    <input type="file" name="image"
        class="w-full p-3 border border-gray-600 text-gray-300 bg-gray-700 rounded-md"
        accept="image/*">

    @if($user && $user->image)
        <div class="mt-3">
            <img src="{{ asset('storage/' . $user->image) }}"
                class="w-20 h-20 object-cover rounded-full">
        </div>
    @endif

    @error('image')
        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
    @enderror
</div>

<!-- Button -->
<button type="submit"
    class="bg-indigo-600 text-white py-3 px-6 rounded-md hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-600 w-full transition">
    {{ $user ? 'Update User' : 'Create User' }}
</button>
</form>
