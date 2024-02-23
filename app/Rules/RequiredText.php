<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class RequiredText implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        preg_match_all('/<code>(.*?)<\/code>/s', $value, $codeMatches);
        $codeText = implode('', $codeMatches[1]);
    
        // Удаляем все теги, кроме <code>
        $textOnly = preg_replace('/<code>(.*?)<\/code>/', '', $value);
    
        // Проверяем, содержит ли оставшийся текст какие-либо символы
        if (strlen(trim(strip_tags($textOnly))) === 0 && strlen(trim($codeText)) === 0) {
            $fail('The field must contain text');
        }
    }
}
