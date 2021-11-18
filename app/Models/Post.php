<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $guarded = [];
    
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function review()
    {
        return $this->hasMany(Review::class);
    }

    public function favorited()
    {
        return (bool) Favourite::where('user_id', Auth::id())
                            ->where('post_id', $this->id)
                            ->first();
    }
    
}
