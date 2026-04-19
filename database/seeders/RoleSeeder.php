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

Permission::firstOrCreate(['name' => 'news.create']);
Permission::firstOrCreate(['name' => 'news.edit']);
Permission::firstOrCreate(['name' => 'news.delete']);

// Create permissions for Post
Permission::firstOrCreate(['name' => 'post.create']);
Permission::firstOrCreate(['name' => 'post.edit']);
Permission::firstOrCreate(['name' => 'post.delete']);

// Create permissions for Comment
Permission::firstOrCreate(['name' => 'comment.create']);
Permission::firstOrCreate(['name' => 'comment.edit']);
Permission::firstOrCreate(['name' => 'comment.delete']);

// Create permissions for Category
Permission::firstOrCreate(['name' => 'category.create']);
Permission::firstOrCreate(['name' => 'category.edit']);
Permission::firstOrCreate(['name' => 'category.delete']);

// Create permissions for User
Permission::firstOrCreate(['name' => 'user.create']);
Permission::firstOrCreate(['name' => 'user.edit']);
Permission::firstOrCreate(['name' => 'user.delete']);



// Create roles and assign permissions
$adminRole = Role::firstOrCreate(['name' => 'admin']);

$adminRole->givePermissionTo(Permission::all()); // Admin can do everything



$editorRole = Role::firstOrCreate(['name' => 'writer']);
$editorRole->givePermissionTo([

    'news.create',
    'news.edit',
    'news.delete',

    'post.create',
    'post.edit',
    'post.delete',
    
    'comment.create',
    'comment.edit',
    'comment.delete'
]);


$userRole = Role::firstOrCreate(['name' => 'user']);
$userRole->givePermissionTo([
    'comment.create',
    'comment.edit',
    'comment.delete'
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