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

    <!-- Check if the user has permission to create a new user, and if so, display the form for creating a new user -->
    @can('create', App\Models\User::class)
        <!-- Form for creating a new user -->
        <div class="bg-gray-800 p-8 rounded-lg shadow-lg mb-8 border border-gray-700 max-w-full overflow-hidden">
            <h3 class="text-3xl text-white mb-6">Create User</h3>

            <!-- The form for creating a user -->
            <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
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
    @endcan
    <!-- Check if the user has permission to view any users, and if so, display the list of existing users -->
    @can('viewAny', App\Models\User::class)
        <!-- List of existing users -->
        <div class="bg-gray-800 p-8 rounded-lg shadow-lg border border-gray-700 max-w-full overflow-hidden">
            <h3 class="text-3xl text-white mb-6">Existing Users</h3>

            <!-- Display a list of existing users -->
            <ul class="space-y-6">
                @foreach ($users as $user)
                    <li class="flex justify-between items-center bg-gray-700 p-4 rounded-lg shadow w-full overflow-hidden">
                        <!-- User information -->
                        <div class="flex-1 max-w-[70%]">
                        <img src="{{ $user->image ? asset('storage/' . $user->image) : asset('storage/images/user_image.png') }}" alt="{{ $user->name }}" class="w-10 h-10 rounded-full object-cover mr-2">

                            <div class="flex items-center">
                                <!-- Display user name -->
                                <span class="font-medium text-gray-300 mr-2">Name:</span>
                                <span class="text-white text-2xl">{{ $user->name }}</span>
                            </div>
                            
                            <div class="flex items-center mb-2">
                                <!-- Display user email -->
                                <span class="font-medium text-gray-300 mr-2">Email:</span>
                                <span class="text-gray-300 text-xl">{{ $user->email }}</span>
                            </div>
                            
                            <div class="flex items-center mb-2">
                                <!-- Display user role -->
                                <span class="font-medium text-gray-300 mr-2">Role:</span>
                                @foreach($user->roles as $role)
                                <span class="text-blue-600 text-xl">{{ $role->name }}</span>
                                @endforeach
                            </div>
                        </div>
                        <div class="flex space-x-4 ml-4 min-w-[120px]">
                        <!-- Check if the user has permission to update the user, and if so, display the edit button -->
                        @can('update', $user)
                            <!-- Edit Button -->
                            <a href="{{ route('users.edit', $user->id) }}" class="text-yellow-500 hover:text-yellow-700">Edit</a>
                        @endcan
                        <!-- Check if the user has permission to delete the user, and if so, display the delete button with -->
                        @can('delete', $user)
                            <!-- Delete Form (with confirmation prompt) -->
                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE') <!-- Specifies the DELETE HTTP method -->
                                <!-- Confirm deletion with a confirmation dialog before proceeding -->
                                <button type="submit" class="text-red-600 hover:text-red-500" onclick="return confirm('Are you sure you want to delete this User?')">Delete</button>
                            </form>
                        @endcan
                        </div>
                    </li>
                @endforeach 
            </ul>
        <div class="mt-6">
        {{ $users->links() }} <!-- Pagination links for navigating through the list of users -->
        </div>
    @endcan
    </div>
</div>
</x-app-layout>
