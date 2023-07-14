<?php

namespace App\Rules\Categories;

use App\Models\Categories;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class PostExist implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $category = Categories::find($value);

        if (empty($category) && $value != null) {
            $fail('Please put a category that exists.');
        }
    }
}
