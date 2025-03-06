<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\News;  
use Illuminate\Support\Facades\File;  
use App\Models\Category;  

class NewsSeeder extends Seeder
{
    public function run()
    {
        // Path to the JSON file where the news data is stored
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

        // Fetch all category IDs from the categories table in the database
        $categories = Category::all()->pluck('id')->toArray();  // Get the category IDs as an array

        // Loop through each news record in the JSON data
        foreach ($data['record'] as $item) {
            // Randomly pick a category ID from the list of available categories
            $randomCategoryId = $categories[array_rand($categories)];  // array_rand picks a random category ID

            // Create a new news item in the database using the data from the JSON file
            News::create([
                'title' => $item['title'],  // Set the title of the news item from the JSON data
                'content' => $item['content'],  // Set the content of the news item from the JSON data
                'image' => $item['image'] ?? null,  // Set the image URL (or null if not present)
                'category_id' => $randomCategoryId,  // Set the category ID randomly picked from available categories
                'user_id' => 2,  // Assign the news item to a specific user with ID 2 (adjust as needed)
            ]);
        }

        // Print a success message once all news items are inserted into the database
        $this->command->info('News data imported successfully!');
    }
}
