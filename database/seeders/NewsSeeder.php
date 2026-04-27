<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;  
use app\Models\Post;
use App\Models\Category; 
use Faker\Factory as Faker;


class NewsSeeder extends Seeder
{
    public function run()
    {
        /* 
        //Path to the JSON file where the news data is stored
        $path = storage_path('app/Newsjson.txt');  // Using storage_path to get the path to the JSON file

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

        // Check if the 'record' key exists and contains an array of news records
        if (!isset($data['record']) || !is_array($data['record'])) {
            // If 'record' key is missing or doesn't contain an array, print an error message
            $this->command->error('No valid news records found in the JSON!');
            return;  // Exit the function if no valid news records are found
        }
        */

        // Fetch all category IDs from the categories table in the database

        $faker = Faker::create('en_US');  // Create an instance of Faker

        // Fetch all category IDs from the categories table
        $categories = Category::all()->pluck('id')->toArray();

        // Generate 10 random news records
        foreach (range(1, 10) as $index) {
            // Pick a random category
            $randomCategoryId = $categories[array_rand($categories)];

            // Using a static random image URL from picsum.photos
            $imageUrl = "https://picsum.photos/400/400?random=" . $index;  // Randomize the URL with the $index


            // Create a random news record
            Post::create([
                'title' => $faker->realText(50), // generates ~50 characters of English text
                'content' => $faker->realText(200), // generates ~200 characters of English text
                'image' => $imageUrl,  // Use external image URL
                'category_id' => $randomCategoryId,  // Random category ID
                'user_id' => 1,  // Hardcoded user ID (you can change it)
                'type' => 'news',  // Set the type to 'news'
            ]);
        }

        $this->command->info('News data generated successfully!');
    }
}
