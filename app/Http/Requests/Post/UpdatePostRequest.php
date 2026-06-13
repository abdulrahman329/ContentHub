<?php

namespace App\Http\Requests\Post;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Post;

class UpdatePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('post')); // Check if the user has permission to update the specific post
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'max:255'], // Ensure a title is provided and does not exceed 255 characters

            'content' => ['required', 'string'],  // Ensure content is provided

            'category_id' => ['required','exists:categories,id'], // Ensure a category is selected

            'type' => ['required', Rule::in(Post::types())], // Ensure the type is one of the allowed values defined in the Post model
            
            'image' => ['sometimes','image', 'mimes:jpeg,png,jpg,gif,svg','max:2048'],  // Optional image upload with validation
        ];
    }
}
