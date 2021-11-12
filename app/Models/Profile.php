<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; 
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $guarded = [];

    /*protected $fillable = [
        'title',
    ];*/

    public function profileImage()
    {
        $imagePath = ($this->image) ? $this->image : 'https://brmil.s3.us-east-2.amazonaws.com/images/1426633644114.jpg';
        return '/storage/' . $imagePath;
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
    
    public function followers(){
        return $this->belongsToMany(User::class);
    }

}
