<?php

namespace App\Rules\Users;

use App\Models\ResetPassword;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CheckCode implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $code = ResetPassword::where('code', $value)->first();

        if (empty($code)) abort(404, 'Code not found');
    }
}
