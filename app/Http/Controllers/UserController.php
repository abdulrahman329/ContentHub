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

    $roles = Role::where('name', '!=', 'super_admin')->get();
    $users = User::with('roles')->latest()->paginate(5);
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

    // Retrieve all roles
    $roles = Role::where('name', '!=', 'super_admin')->get();

    return view('user.edit', compact('user', 'roles')); // Return edit form for a specific user
}

// Update the User details
public function update(UpdateUserRequest $request, User $user)
{

    $validated = $request->validated();

    if ($request->hasFile('image')) {
        deleteImage($user->image);
        $validated['image'] = storeImage($request->file('image'));
    }

    
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

        deleteImage($user->image);
        $user->forceDelete();

        return back()->with('success', 'User permanently deleted!');
    }
}
