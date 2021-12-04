<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id',
        'user_id',
        'comment',
        'username',
        'thumbs_up',
    ];


    public function post(){
        return $this->belongsTo(Post::class);
    }
    //protected $table = "reviews";
}
