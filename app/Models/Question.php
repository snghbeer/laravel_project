<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'question',
        'answer',
        'category_id'
    ];

    public function category(){
        return $this->belongsTo(FaqCategory::class, 'category_id'); //has only one category
    }
}
