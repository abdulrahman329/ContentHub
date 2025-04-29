<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;  
use Illuminate\Support\Facades\File;  
use App\Models\Category;  
use Faker\Factory as Faker;


class PostsSeeder extends Seeder
{
    public function run()
    {
        /*
        // Path to the JSON file where the post data is stored
        $path = storage_path('app/Postsjson.txt');  // Using storage_path to get the path to the JSON file

        // Check if the file exists at the specified path
        if (!file_exists($path)) {
            // If the file doesn't exist, print an error message
            $this->command->error('File not found!');
            return;  // Exit the function if the file is not found
        }

        // Read the contents of the JSON file into a string
        $json = File::get($path);

        // Decode the JSON string into a PHP associative array
        $data = json_decode($json, true);

        // Check if the JSON is valid (if there are any errors during decoding)
        if (json_last_error() !== JSON_ERROR_NONE) {
            // If there's an error in decoding, print an error message
            $this->command->error('Invalid JSON in file!');
            return;  // Exit the function if JSON is invalid
        }

        // Check if the 'record' key exists and contains an array of posts
        if (!isset($data['record']) || !is_array($data['record'])) {
            // If 'record' key is missing or doesn't contain an array, print an error message
            $this->command->error('No valid post records found in the JSON!');
            return;  // Exit the function if no valid post records are found
        }
        */

        $faker = Faker::create();  // Create an instance of Faker

        // Fetch all category IDs from the categories table
        $categories = Category::all()->pluck('id')->toArray();

        // Generate 10 random news records
        foreach (range(1, 10) as $index) {
            // Pick a random category
            $randomCategoryId = $categories[array_rand($categories)];

            // Using a static random image URL from picsum.photos
            $imageUrl = "https://picsum.photos/400/400?random=" . $index;  // Randomize the URL with the $index


            // Create a random Post record
            Post::create([
                'title' => $faker->sentence,  // Random title
                'content' => $faker->paragraph,  // Random content
                'image' => $imageUrl,  // Use external image URL
                'category_id' => $randomCategoryId,  // Random category ID
                'user_id' => 1,  // Hardcoded user ID (you can change it)
            ]);
        }

        $this->command->info('Post data generated successfully!');
    }
}
