<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Author extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $guard = 'author';

    protected $guarded = ['id'];
    function rel_to_post(){
        return $this->hasMany(post::class, 'author_id');
    }
}
