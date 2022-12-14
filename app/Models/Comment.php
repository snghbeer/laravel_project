<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = [
        'author',
        'content',
        'news_id',
    ];

    public function post(){
        return $this->belongsTo(News::class, 'news_id'); //has only one post
    }
}
