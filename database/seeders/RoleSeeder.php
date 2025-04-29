<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
// Create permissions for News
Permission::firstOrCreate(['name' => 'create_News']);
Permission::firstOrCreate(['name' => 'Edit_News']);
Permission::firstOrCreate(['name' => 'Delete_News']);

// Create permissions for Post
Permission::firstOrCreate(['name' => 'create_Post']);
Permission::firstOrCreate(['name' => 'Edit_Post']);
Permission::firstOrCreate(['name' => 'Delete_Post']);

// Create permissions for Comment
Permission::firstOrCreate(['name' => 'create_Comment']);
Permission::firstOrCreate(['name' => 'Edit_Comment']);
Permission::firstOrCreate(['name' => 'Delete_Comment']);

// Create permissions for Category
Permission::firstOrCreate(['name' => 'create_Category']);
Permission::firstOrCreate(['name' => 'Edit_Category']);
Permission::firstOrCreate(['name' => 'Delete_Category']);

// Create permissions for User
Permission::firstOrCreate(['name' => 'create_User']);
Permission::firstOrCreate(['name' => 'Edit_User']);
Permission::firstOrCreate(['name' => 'Delete_User']);



// Create roles and assign permissions
$adminRole = Role::firstOrCreate(['name' => 'admin']);

$adminRole->givePermissionTo(Permission::all()); // Admin can do everything



$editorRole = Role::firstOrCreate(['name' => 'writer']);
$editorRole->givePermissionTo([
    'create_News',
    'Edit_News',
    'Delete_News',

    'create_Post',
    'Edit_Post',
    'Delete_Post',

    'create_Comment',
    'Edit_Comment',
    'Delete_Comment'
]);


$userRole = Role::firstOrCreate(['name' => 'user']);
$userRole->givePermissionTo([
    'create_Comment',
    'Edit_Comment',
    'Delete_Comment'
]);


        // Assign role to user (ensure user exists)
        $user = User::find(1); // Check if the user exists, or handle creating a user
        if ($user) {
            $user->assignRole('admin'); // Assign 'admin' role to user
        } else {
            // You might want to create a user if not found
            $user = User::create([
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'image' => 'images/user_image.png',
                'password' => bcrypt('12345678') // Don't forget to hash passwords
            ]);
            $user->assignRole('admin');
        }

    }
}