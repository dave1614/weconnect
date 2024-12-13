<?php

namespace App\Rules;

use App\Models\InecState;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class StateVerificationRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $state = InecState::find($value);
        if (!$state) {
            $fail('The :attribute is invalid.');
        }
    }
}
