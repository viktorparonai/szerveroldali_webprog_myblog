<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

#[Fillable(['name', 'color'])]

class Category extends Model
{
    use HasFactory;

    public function posts(){
        return $this -> belongsToMany(Post::Class)->withTimestamps();
    }
}
