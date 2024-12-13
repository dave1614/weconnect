<?php

namespace App\Rules;

use App\Models\InecLga;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class LgaVerificationRule implements ValidationRule
{
    public $state_id;

    public function __construct($state_id)
    {
        $this->state_id = $state_id;
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $lga = InecLga::where('inec_state_id', $this->state_id)->where('id', $value)->first();
        if(!$lga){
            $fail('The local government selected is invalid.');
        }
    }
}
