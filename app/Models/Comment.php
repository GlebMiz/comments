<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'text',
        'user_id',
        'reply_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function replies(){
        return $this->hasMany(Comment::class,'reply_id');
    }

    public function parent(){
        return $this->belongsTo(Comment::class,'reply_id');
    }
}
