<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentInsertRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'email'],
            'homepage' => ['required', 'string', 'max:255'],
            'text' => ['required', 'string', 'max:1000'],
        ];
    }
}
