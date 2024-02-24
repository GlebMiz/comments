<?php

namespace App\Http\Requests;

use App\Rules\Captcha;
use App\Rules\HtmlTagsClosed;
use App\Rules\LatinSymbols;
use App\Rules\RequiredText;
use Illuminate\Foundation\Http\FormRequest;

class CommentInsertRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', new LatinSymbols],
            'email' => ['required', 'string', 'email', 'max:255', new LatinSymbols],
            'homepage' => ['max:255', new LatinSymbols],
            'text' => ['required',new RequiredText, 'string', 'max:1000', new HtmlTagsClosed, new LatinSymbols],
            'file' => ['file','mimes:txt','max:100'],
            'image' => ['file','mimes:png,gif,jpg','max:10000'],
            'captcha' => ['required',new Captcha],
        ];
    }
}
