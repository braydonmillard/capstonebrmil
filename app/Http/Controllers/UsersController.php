<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class UsersController extends Controller
{
    public function __contruct(){
        $this->middleware('auth');
    }
    
    public function myFavourites()
    {
    $myFavourites = auth()->user()->favourites;

    return view('users.my_favourites', compact('myFavourites'));
    }
}
