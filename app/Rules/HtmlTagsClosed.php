<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class HtmlTagsClosed implements ValidationRule
{

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $textOnly = strip_tags($value);
        preg_match_all('/<[^>]*>/', $textOnly, $matches);

        if (!empty($matches[0])) {
            $fail('HTML tags must be properly closed');
        }
    }
}
