<x-app-layout>
    <!-- Header section for the page -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            {{ __('Edit User') }}
        </h2>
    </x-slot>

    <div class="container mx-auto px-8 py-12">
        <!-- Display success message if there's any -->
        @if (session('success'))
            <div class="bg-green-500 text-white p-4 mb-6 rounded">
                {{ session('success') }}
            </div>
        @endif

        <!-- Main content area for editing user -->
        <div class="bg-gray-800 p-8 rounded-lg shadow-lg mb-8">
            <h3 class="text-2xl text-white mb-4">Edit User</h3>

            @can('update', $user)
            <!-- Form for updating user details -->
            <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')  <!-- Specifies the method as PUT for updating -->

                <!-- Input for user's name -->
                <div class="mb-4">
                    <label for="name" class="mb-1 block text-gray-300 text-sm font-semibold">User Name</label>
                    <input type="text" name="name" id="name" class="w-full p-4 text-gray-300 bg-gray-700 border rounded-md" placeholder="Enter User name" required value="{{ old('name', $user->name) }}">
                    <!-- Display error message for 'name' field if validation fails -->
                    @error('name')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Input for user's email -->
                <div class="mb-4">
                    <label for="email" class="mb-1 block text-gray-300 text-sm font-semibold">User email</label>
                    <input type="text" name="email" id="email" class="w-full p-4 text-gray-300 bg-gray-700 border rounded-md" placeholder="Enter User email" required value="{{ old('email', $user->email) }}">
                    <!-- Display error message for 'email' field if validation fails -->
                    @error('email')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Input for user's password -->
                <div class="mb-4">
                    <label for="password" class="mb-1 block text-gray-300 text-sm font-semibold">User password</label>
                    <input type="password" name="password" id="password" class="w-full p-4 text-gray-300 bg-gray-700 border rounded-md" placeholder="Enter new password (leave blank to keep current)">
                    <!-- Display error message for 'password' field if validation fails -->
                    @error('password')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Select input for user's role -->
                <div class="mb-4">
                    <label for="role" class="block text-sm font-medium text-gray-300">Role</label>
                    <select name="role" id="role" class="mt-1 block w-full px-3 py-2 border border-gray-600 rounded-md shadow-sm bg-gray-700 text-gray-300" required>
                        <!-- Loop through roles array and display each role as an option -->
                    @foreach($roles as $role)
                        <option value="{{ $role->name }}"
                            {{ old('role', $user->roles->first()?->name) == $role->name ? 'selected' : '' }}>
                            {{ $role->name }}
                        </option>
                    @endforeach
                    </select>
                <div class="mb-2 text-gray-300">
                    Current Role:
                    <span class="text-blue-400 font-bold">
                        {{ $user->roles->first()?->name ?? 'No role' }}
                    </span>
                </div>
                    @error('role')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror

                <!-- Input for user's profile image -->
                <div class="mt-4 mb-4">
                    <label for="image" class="mb-1 block text-gray-300 text-sm font-semibold">Profile Image</label>
                    <input type="file" name="image" id="image" class=" w-full p-4 border border-gray-600 text-gray-300 bg-gray-700 rounded-md" accept="image/*">
                    @if($user->image)
                        <div class="mt-2">
                            <img src="{{ asset('storage/' . $user->image) }}" alt="Profile Image" class="mb-4 mt-4 w-20 h-20 object-cover rounded-full">
                        </div>
                    @endif
                    @error('image')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                    </select>
                    <!-- Display error message for 'role' field if validation fails -->
                    @error('role')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                

                <!-- Submit button to update user -->
                <button type="submit" class=" bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-800 w-full">Update User</button>
            </form>
        @endcan
        </div>
    </div>
    </div>
    </div>
</x-app-layout>
