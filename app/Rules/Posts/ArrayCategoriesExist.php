<?php

namespace App\Rules\Posts;

use App\Models\Categories;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ArrayCategoriesExist implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if(count($value) > 0) {
            $categories = $value;
            foreach($categories as $category) {
                $category = Categories::find($category);

                if (empty($category) && $value != null) {
                    $fail('Please put a category that exists.');
                }
            }

        }

    }
}
