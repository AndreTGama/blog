<?php

namespace App\Http\Requests\Post;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'cover_image' => ['nullable', 'string', 'max:255'],
            'title' => ['required', 'string', 'max:255'],
            'excerpt' => ['required', 'string'],
            'content' => ['required', 'string'],
            'status' => ['required', 'in:draft,published,archived'],

            'post_meta' => ['nullable', 'array'],
            'post_meta.*.key' => ['required_with:post_meta', 'string', 'max:255'],
            'post_meta.*.value' => ['required_with:post_meta', 'string'],

            'category_ids' => ['required', 'array'],
            'category_ids.*' => ['string', 'exists:categories,id'],
        ];
    }
}
