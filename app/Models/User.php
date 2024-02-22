<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
      protected $fillable = [
        'username',
        'email',
        'homepage',
    ];

    public function comments(){
        return $this->hasMany(Comment::class);
    }
}
