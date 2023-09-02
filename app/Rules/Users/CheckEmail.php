<?php

namespace App\Rules\Users;

use App\Models\User;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CheckEmail implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $user = User::withTrashed()->where('email', $value)->first();

        if (empty($user)) abort(404, 'This email does not exist in the system.');
    }
}
