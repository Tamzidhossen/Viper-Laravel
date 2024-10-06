<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    function replies(){
        return $this->hasMany(Comment::class, 'parent_id', 'id');
    }

    function rel_to_author(){
        return $this->belongsTo(Author::class, 'author_id');
    }
}
