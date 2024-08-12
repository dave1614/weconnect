<?php

namespace App\Rules;

use App\Functions\UsefulFunctions;
use Illuminate\Contracts\Validation\Rule;

class EducationalServiceRule implements Rule
{

    public UsefulFunctions $functions;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->functions = new UsefulFunctions();
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $vtu_platform = $this->functions->getVtuPlatformToUse('educational', $value);

        if($value == "waec" && ($vtu_platform == "payscribe" || $vtu_platform == "clubkonnect")){
            return true;
        }else if($value == "neco" && $vtu_platform == "payscribe"){
            return true;
        }else{
            return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The entered service is invalid';
    }
}
