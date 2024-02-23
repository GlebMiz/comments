<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommentFile extends Model
{
    public $table = 'comments_files';
    protected $fillable = [
        'path',
        'name',
        'type',
        'comment_id'
    ];

    public function comment(){
        return $this->belongsTo(Comment::class);
    }
}
