<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Session;

class Captcha
{
    public static function generateCaptcha()
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $randomString = '';
        for ($i = 0; $i < 5; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }

        Session::put('captcha',$randomString);
        return $randomString;
    }

    public static function checkCaptcha($value){
        return $value == Session::get('captcha');
    }
}
