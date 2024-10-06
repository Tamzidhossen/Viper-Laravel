<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class post extends Model
{
    use HasFactory;
    protected $guarded=['author'];

    // protected $guard=['id'];
    function rel_to_category(){
        return $this->belongsTo(Category::class, 'category_id');
    }
    function rel_to_author(){
        return $this->belongsTo(Author::class, 'author_id');
    }
}
