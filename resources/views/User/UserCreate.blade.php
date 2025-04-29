<x-app-layout>
    <!-- Header section for the page -->
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-white leading-tight">
            {{ __('Create User') }}
        </h2>
    </x-slot>

    <div class="container mx-auto px-6 py-12 overflow-hidden">
        <!-- Display success message if there's any -->
        @if (session('success'))
            <div class="bg-green-600 text-white p-4 mb-6 rounded-lg shadow-lg">
                {{ session('success') }}
            </div>
        @endif

        <!-- Form for creating a new user -->
        <div class="bg-gray-800 p-8 rounded-lg shadow-lg mb-8 border border-gray-700 max-w-full overflow-hidden">
            <h3 class="text-3xl text-white mb-6">Create User</h3>

            @if(Auth::user()->hasRole('admin'))

            <!-- The form for creating a user -->
            <form action="{{ route('User.store') }}" method="POST" enctype="multipart/form-data">
                @csrf <!-- CSRF protection to secure the form -->
                
                <!-- Input for user's name -->
                <div class="mb-6">
                    <label for="name" class="block text-gray-300 text-sm font-medium">User Name</label>
                    <input type="text" name="name" id="name" class="w-full p-3 mt-2 border border-gray-600 rounded-md focus:ring-2 focus:ring-indigo-600 bg-gray-700 text-white" placeholder="Enter User name" required value="{{ old('name') }}">
                    <!-- Display error message for 'name' field if validation fails -->
                    @error('name')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Input for user's email -->
                <div class="mb-6">
                    <label for="email" class="block text-gray-300 text-sm font-medium">User email</label>
                    <input type="email" name="email" id="email" class="w-full p-3 mt-2 border border-gray-600 rounded-md focus:ring-2 focus:ring-indigo-600 bg-gray-700 text-white" placeholder="Enter User email" required value="{{ old('email') }}">
                    <!-- Display error message for 'email' field if validation fails -->
                    @error('email')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Input for user's password -->
                <div class="mb-6">
                    <label for="password" class="block text-gray-300 text-sm font-medium">User password</label>
                    <input type="password" name="password" id="password" class="w-full p-3 mt-2 border border-gray-600 rounded-md focus:ring-2 focus:ring-indigo-600 bg-gray-700 text-white" placeholder="Enter User password" required value="{{ old('password') }}">
                    <!-- Display error message for 'password' field if validation fails -->
                    @error('password')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Select input for user's role -->
                <div class="mb-6">
                    <label for="role" class="block text-gray-300 text-sm font-medium">Role</label>
                    <select name="role" id="role" class="w-full p-3 mt-2 border border-gray-600 rounded-md focus:ring-2 focus:ring-indigo-600 bg-gray-700 text-white" required>
                        <!-- Loop through the available roles and display each as an option -->
                        @foreach($roles as $role)
                            <option value="{{ $role->name }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Profile Image Upload -->
                <div class="mb-6">
                    <label for="image" class="block text-gray-300 text-sm font-semibold ">Profile Image</label>
                    <input type="file" name="image" id="image" class="w-full p-4 border border-gray-600 text-gray-300  bg-gray-700 rounded-md" accept="image/*">
                </div>

                <!-- Submit button to create a new user -->
                <button type="submit" class="bg-indigo-600 text-white py-3 px-6 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-600 w-full">Create User</button>
            </form>
        </div>

        <!-- List of existing users -->
        <div class="bg-gray-800 p-8 rounded-lg shadow-lg border border-gray-700 max-w-full overflow-hidden">
            <h3 class="text-3xl text-white mb-6">Existing Users</h3>

            <!-- Display a list of existing users -->
            <ul class="space-y-6">
                @foreach ($Users as $User)
                    <li class="flex justify-between items-center bg-gray-700 p-4 rounded-lg shadow w-full overflow-hidden">
                        <!-- User information -->
                        <div class="flex-1 max-w-[70%]">
                        <img src="{{ $User->image ? asset('storage/' . $User->image) : asset('storage/images/user_image.png') }}" alt="{{ $User->name }}" class="w-10 h-10 rounded-full object-cover mr-2">

                            <div class="flex items-center">
                                <!-- Display user name -->
                                <span class="font-medium text-gray-300 mr-2">Name:</span>
                                <span class="text-white text-2xl">{{ $User->name }}</span>
                            </div>
                            
                            <div class="flex items-center mb-2">
                                <!-- Display user email -->
                                <span class="font-medium text-gray-300 mr-2">Email:</span>
                                <span class="text-gray-300 text-xl">{{ $User->email }}</span>
                            </div>
                            
                            <div class="flex items-center mb-2">
                                <!-- Display user role -->
                                <span class="font-medium text-gray-300 mr-2">Role:</span>
                                @foreach($User->roles as $role)
                                <span class="text-blue-600 text-xl">{{ $role->name }}</span>
                                @endforeach
                            </div>
                        </div>
                        <hr>

                        <!-- Edit and Delete Buttons Container -->
                        <div class="flex space-x-4 ml-4 min-w-[120px]">
                            <!-- Edit Button -->
                            <a href="{{ route('User.edit', $User->id) }}" class="text-yellow-500 hover:text-yellow-700">Edit</a>

                            <!-- Delete Form (with confirmation prompt) -->
                            <form action="{{ route('User.destroy', $User->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE') <!-- Specifies the DELETE HTTP method -->
                                <!-- Confirm deletion with a confirmation dialog before proceeding -->
                                <button type="submit" class="text-red-600 hover:text-red-500" onclick="return confirm('Are you sure you want to delete this User?')">Delete</button>
                            </form>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
        @else
        <p class='text-white'>You don't have the authority, you have to be an admin</p>
        @endif
    </div>
</x-app-layout>
