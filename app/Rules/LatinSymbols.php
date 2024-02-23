<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\ValidationRule;
use Closure;

class LatinSymbols implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($value && !preg_match('/[a-zA-Z\s\x{0080}-\x{024F}]/u', $value)) 
            $fail('Field must contain only latin letters');      
    }
}
