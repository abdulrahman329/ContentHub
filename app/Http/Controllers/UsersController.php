<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; 
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller

{
    // Show the User creation form
    public function create()
    {
        $roles = Role::all(); // Retrieve all roles from the database
        $Users = User::all();  // Fetch all users

        // Return the view with users and roles to show the user creation form
        return view('User.UserCreate', compact('Users', 'roles'));
    }

    // Store the newly created User
    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email', // Ensure email is unique
            'password' => 'required|string|min:8', // Ensure password has at least 8 characters
            'role' => 'required|string', // Validate the role
        ]);

        // Create the new User with the hashed password
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Hash the password before saving
        ]);

        // Assign the role to the user
        $user->assignRole($request->role);  // Assign the role using Spatie's method

        // Redirect to the User creation page with a success message
        return redirect()->route('User.create')->with('success', 'User created successfully!');
    }

    // Show the form to edit a User
    public function edit(User $User)
    {
        // Retrieve all roles
        $roles = Role::all(); 
        return view('User.UserEdit', compact('User', 'roles')); // Return edit form for a specific user
    }

    // Update the User details
    public function update(Request $request, User $User)
    {
        // Validate the updated User data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $User->id, // Ensure email is unique but ignores the current user
            'password' => 'nullable|string|min:8', // Password is optional for updates
            'role' => 'required|string',
        ]);

        // Update the User details, ensuring password is only updated if provided
        $User->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->filled('password') ? Hash::make($request->password) : $User->password, // Only update password if it's provided
        ]);

        // Reassign the role (if it's changed)
        $User->syncRoles($request->role);  // Sync roles to ensure that the user's role is updated

        // Redirect with a success message
        return redirect()->route('User.create')->with('success', 'User updated successfully!');
    }

    // Delete the User
    public function destroy(User $User)
    {
        // Delete the user from the database
        $User->delete();

        // Redirect with a success message
        return redirect()->route('User.create')->with('success', 'User deleted successfully!');
    }
}
