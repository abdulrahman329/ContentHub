<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class UserController extends Controller
{

    use AuthorizesRequests;

// Show the User creation form
public function create()
{
    $this->authorize('create', User::class); // Authorize that the user can create a new User

    $roles = Role::where('name', '!=', 'super_admin')->get();
    $users = User::with('roles')->latest()->paginate(5);
    $trashedCount = User::onlyTrashed()->count();

    // Return the view with users and roles to show the user creation form
    return view('user.create', compact('users', 'roles', 'trashedCount'));
}

// Store the newly created User
public function store(Request $request)
{
    $this->authorize('create', User::class); // Authorize that the user can create a new User

    // Validate the incoming request data
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email', // Ensure email is unique
        'password' => 'required|string|min:8', // Ensure password has at least 8 characters
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',  // Optional image upload with validation
        'role' => 'required|exists:roles,name|not_in:super_admin',
    ]);

    // Check if an image file was uploaded with the request
    if ($request->hasFile('image')) {
        // Store the uploaded image and save its path
        $imagePath = $request->file('image')->store('images', 'public');
    } else {
        // If no image is uploaded, set a default image path
        $imagePath = 'images/user_image.png'; // Ensure you have a default image stored in public/images
    }

    // Create the new User with the hashed password
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password), // Hash the password before saving
        'image' => $imagePath,
    ]);

    // Assign the role to the user
    $user->assignRole($request->role);  // Assign the role using Spatie's method

    // Redirect to the User creation page with a success message
    return redirect()->route('users.create')->with('success', 'User created successfully!');
}

// Show the form to edit a User
public function edit(User $user)
{
    $this->authorize('update', $user); // Authorize that the user can update this User
    // Retrieve all roles
    $roles = Role::where('name', '!=', 'super_admin')->get();

    return view('user.edit', compact('user', 'roles')); // Return edit form for a specific user
}

// Update the User details
public function update(Request $request, User $user)
{
    $this->authorize('update', $user); // Authorize that the user can update this User

    // Validate the updated User data
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $user->id, // Ensure email is unique but ignores the current user
        'password' => 'nullable|string|min:8', // Password is optional for updates
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',  // Optional image upload with validation
        'role' => 'required|exists:roles,name|not_in:super_admin',
    ]);

    if ($user->hasRole('super_admin') && $request->role !== 'super_admin') {
        abort(403, 'Super Admin role cannot be changed.');
    }

    // Check if an image file was uploaded with the request
    if ($request->hasFile('image')) {

        deleteImage($user->image);

        // Store the new uploaded image and save its path
        $imagePath = $request->file('image')->store('images', 'public');
    } else {
        // Keep the current image path if no new image is uploaded
        $imagePath = $user->image;
    }

    $this->authorize('changeRole', $user);

    // Update the User details, ensuring password is only updated if provided
    $user->update([
        'name' => $request->name,
        'email' => $request->email,
        'password' => $request->filled('password') ? Hash::make($request->password) : $user->password, // Only update password if it's provided
        'image' => $imagePath,
    ]);

    $user->syncRoles($request->role);  // Sync roles to ensure that the user's role is updated

    // Redirect with a success message
    return redirect()->route('users.create')->with('success', 'User updated successfully!');
}

// Delete the User
public function destroy(User $user)
{
    $this->authorize('delete', $user); // Authorize that the user can delete this User

    if (auth()->id() === $user->id && $user->hasRole('super_admin')) {
        abort(403, 'Super Admin cannot delete themselves.');
    }

    // Delete the user from the database
    $user->delete();

    // Redirect with a success message
    return redirect()->route('users.create')->with('success', 'User deleted successfully!');
}

    public function trash()
    {
        $this->authorize('viewTrash', User::class);

        $users = User::onlyTrashed()->latest()->paginate(10);

        return view('user.trash', compact('users'));
    }

    public function restore($id)
    {
        $user = User::withTrashed()->findOrFail($id);

        $this->authorize('restore', $user);

        $user->restore();

        return back()->with('success', 'User restored!');
    }

    public function forceDelete($id)
    {
        $user = User::withTrashed()->findOrFail($id);

        $this->authorize('forceDelete', $user);

        deleteImage($user->image);
        $user->forceDelete();

        return back()->with('success', 'User permanently deleted!');
    }
}
