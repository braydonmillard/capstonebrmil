<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Models\Favourite;

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

    public function rating()
    {
        return $this->hasMany(Rating::class);
    }

    public function favourited()
    {
        return (bool) Favourite::where('user_id', Auth::id())
                            ->where('post_id', $this->id)
                            ->first();
    }
    
}
