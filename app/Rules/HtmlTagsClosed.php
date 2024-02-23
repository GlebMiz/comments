<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class HtmlTagsClosed implements ValidationRule
{

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $cleanHtml = preg_replace('/<code>.*?<\/code>/', '<code></code>', $value );
       
        $stack = [];
        $pattern = '/<\/?([a-zA-Z]+)[^>]*>/';
        if (preg_match_all($pattern, $cleanHtml, $matches, PREG_SET_ORDER)) {
            foreach ($matches as $match) {
                $tag = $match[1];
                if ($match[0][1] == '/') {
                    if (empty($stack) || array_pop($stack) !== $tag) {
                        //return false; // Несоответствие
                    }
                } else {
                    // Это открывающий тег, добавляем его в стек
                    $stack[] = $tag;
                }
            }
        }

        //$allTagsClosed = preg_match_all('/<(\w+)(?:(?!<\/\1).)*$/m', $cleanHtml, $matches);
        if (!empty($stack)) {
            $fail('HTML tags must be properly closed');
        }
    }
}
