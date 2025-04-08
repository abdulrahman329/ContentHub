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

            @if(Auth::user()->hasRole('admin'))

            <!-- Form for updating user details -->
            <form action="{{ route('User.update', $User->id) }}" method="POST">
                @csrf
                @method('PUT')  <!-- Specifies the method as PUT for updating -->

                <!-- Input for user's name -->
                <div class="mb-4">
                    <label for="name" class="block text-gray-300 text-sm font-semibold">User Name</label>
                    <input type="text" name="name" id="name" class="w-full p-4 text-gray-300 bg-gray-700 border rounded-md" placeholder="Enter User name" required value="{{ old('name', $User->name) }}">
                    <!-- Display error message for 'name' field if validation fails -->
                    @error('name')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Input for user's email -->
                <div class="mb-4">
                    <label for="email" class="block text-gray-300 text-sm font-semibold">User email</label>
                    <input type="text" name="email" id="email" class="w-full p-4 text-gray-300 bg-gray-700 border rounded-md" placeholder="Enter User email" required value="{{ old('email', $User->email) }}">
                    <!-- Display error message for 'email' field if validation fails -->
                    @error('email')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Input for user's password -->
                <div class="mb-4">
                    <label for="password" class="block text-gray-300 text-sm font-semibold">User password</label>
                    <input type="password" name="password" id="password" class="w-full p-4 text-gray-300 bg-gray-700 border rounded-md" placeholder="Enter new password (leave blank to keep current)" value="{{ old('password') }}">
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
                            <option value="{{ $role->name }}"> {{ (old('role', $User->roles->first()->name) == $role->name) ? 'current role is:' : '' }}
                                {{ $role->name }}
                            </option>
                        @endforeach
                    </select>
                    <!-- Display error message for 'role' field if validation fails -->
                    @error('role')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit button to update user -->
                <button type="submit" class="bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-800 w-full">Update User</button>
            </form>
        </div>
        @else
        <p class='text-white'>You don't have the authority, you have to be an admin</p>
        @endif
    </div>
</x-app-layout>
