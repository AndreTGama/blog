<?php

namespace App\Rules\Categories;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CategoryIdNumberOrNull implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if(gettype($value) != "integer" && $value != null){
            $fail('category_id need by number or null');
        }
    }
}
