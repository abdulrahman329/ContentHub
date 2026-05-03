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


$superAdminRole = Role::firstOrCreate(['name' => 'super_admin']);

// Always sync all permissions 
$superAdminRole->syncPermissions(Permission::all());


// Create roles and assign permissions
$adminRole = Role::firstOrCreate(['name' => 'admin']);

$adminRole->syncPermissions(Permission::all()); // Admin can do everything



$editorRole = Role::firstOrCreate(['name' => 'writer']);
$editorRole->givePermissionTo([

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


$superAdmin = User::firstOrCreate(
    ['email' => 'admin@example.com'],
    [
        'name' => 'Super Admin',
        'image' => 'images/user_image.png',
        'password' => bcrypt('12345678'),
    ]
);

$superAdmin->syncRoles(['super_admin']);

    }
}