<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Call other seeders
        $this->call([
            RoleSeeder::class, // create user + roles
            CategorySeeder::class,
            PostsSeeder::class,
            NewsSeeder::class,
        ]);
    }
}
