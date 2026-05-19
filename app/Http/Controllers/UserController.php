<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;


class UserController extends Controller
{

    use AuthorizesRequests;

    // Show the User creation form
    public function create()
    {
        $this->authorize('create', User::class); // Authorize that the user can create a new User

        // Retrieve all roles except 'super_admin' to assign to the new user
        $roles = Role::where('name', '!=', 'super_admin')->get();

        // Get the latest users with their roles, paginated to show 5 users per page
        $users = User::with('roles')->latest()->paginate(5);

        // Get the count of soft-deleted users to display in the view
        $trashedCount = User::onlyTrashed()->count();

        // Return the view with users and roles to show the user creation form
        return view('user.create', compact('users', 'roles', 'trashedCount'));
    }

    // Store the newly created User
    public function store(StoreUserRequest $request)
    {
        $validated = $request->validated();

        $validated['image'] = $request->hasFile('image')
            ? storeImage($request->file('image'))
            : null;

        // Create the new User with the hashed password
        $user = User::create($validated);

        // Assign the role to the user
        $user->syncRoles([$validated['role']]);

        // Redirect to the User creation page with a success message
        return redirect()->route('users.create')->with('success', 'User created successfully!');
    }

    // Show the form to edit a User
    public function edit(User $user)
    {
        $this->authorize('update', $user); // Authorize that the user can update this User

        // Retrieve all roles except 'super_admin' to assign to the user
        $roles = Role::where('name', '!=', 'super_admin')->get();

        return view('user.edit', compact('user', 'roles')); // Return edit form for a specific user
    }

    // Update the User details
    public function update(UpdateUserRequest $request, User $user)
    {

        $validated = $request->validated();

        // Handle image upload and deletion of old image if a new one is uploaded
        if ($image = $request->file('image')) {
            deleteImage($user->getRawOriginal('image'));
        
            $validated['image'] = storeImage($image);
        }

        // If the password field is empty, remove it from the validated data to prevent overwriting the existing password with null
        if (empty($validated['password'])) {
            unset($validated['password']);
        }

        $this->authorize('changeRole', $user);

        $user->update($validated);
        
        $user->syncRoles([$validated['role']]);


        // Redirect with a success message
        return redirect()->route('users.create')->with('success', 'User updated successfully!');
    }

    // Delete the User
    public function destroy(User $user)
    {
        $this->authorize('delete', $user); // Authorize that the user can delete this User

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

        deleteImage($user->getRawOriginal('image'));

        $user->forceDelete();

        return back()->with('success', 'User permanently deleted!');
    }
}
