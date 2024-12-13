<?php

namespace App\Rules;

use App\Models\InecWard;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class WardVerificationRule implements ValidationRule
{

    public $state_id;
    public $lga_id;

    public function __construct($state_id, $lga_id)
    {
        $this->state_id = $state_id;
        $this->lga_id = $lga_id;
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $ward = InecWard::where('inec_state_id', $this->state_id)->where('inec_lga_id', $this->lga_id)->first();
        if(!$ward){
            $fail('The community selected is invalid.');
        }
    }
}
