<?php

namespace App\Rules;

use App\Helpers\Captcha as CaptchaHelper;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class Captcha implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!CaptchaHelper::checkCaptcha($value)) {
            $fail('Please input correct symbols');
        }
    }
}
