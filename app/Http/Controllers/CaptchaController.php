<?php

namespace App\Http\Controllers;

use App\Helpers\Captcha;

class CaptchaController extends Controller
{
    public function get()
    {
        return response()->json(['code' => Captcha::generateCaptcha()]);
    }
}
