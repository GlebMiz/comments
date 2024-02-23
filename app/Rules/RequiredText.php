<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class RequiredText implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $fail_text = 'Required field';
        if (!$value) {
            $fail($fail_text);
        }
        $trimmedValue = preg_replace('/<[^>]*>/', '', $value);
        if (trim($trimmedValue) == '') {
            $fail($fail_text);
        }
    }
}
