<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Intervention\Image\Facades\Image;


class PostsController extends Controller
{
    public function __construct(){

        //$this->middleware('auth');
    }

    public function index(){
        //$users = auth()->user()->following()->pluck('profiles.user_id');

        //$users = auth()->user()->following()->pluck('profiles.user_id');

        //$posts = Post::whereIn('user_id', $users)->latest()->limit(3)->get();

        $posts = Post::latest()->limit(3)->get();

        //return view('posts.index', compact('posts', 'allposts'));
        return view('posts.index', compact('posts'));
    }

    public function create(){
        return view('posts.create');
    }

    public function show(Post $post){
        
        return view('posts.show', compact('post'));
    }

    public function store(){
        
        
        $data = request()->validate([
            'caption' => 'required',
            'title' => 'required',
            'ingredients' => 'required',
            'instructions' => 'required',
            'image' => ['required', 'image'],
        ]);

        $imagePath = request('image')->store('uploads', 'public');

        //dd(storage_path("{$imagePath}"));
/*
        Storage::disk('s3')->setVisibility($imagePath, 'public');

        $image = Image::create([
            'filename' => basename($imagePath),
            'url' => Storage::disk('s3')->url($imagePath)
        ]);*/

        $image = Image::make(public_path("storage/{$imagePath}")->getRealPath());
        //$img = Image::make($request->file('photo')->getRealPath());

        $image->save();

        auth()->user()->posts()->create([
            'caption' => $data['caption'],
            'title' => $data['title'],
            'ingredients' => $data['ingredients'],
            'instructions' => $data['instructions'],
            'image' => $imagePath,    
        ]);

        return redirect('/profile/' . auth()->user()->id);
    }
}
