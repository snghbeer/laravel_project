<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Question;

class FaqCategory extends Model
{
    use HasFactory;

    public $timestamps = false;

    //protected $primaryKey = 'category_id';


    protected $fillable = [
        'category_name',
    ];

    public function questions()
    {
        return $this->hasMany(Question::class, 'category_id');
    }
}
