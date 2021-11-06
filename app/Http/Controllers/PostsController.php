<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Intervention\Image\Facades\Image;
use Storage;

require('../vendor/autoload.php');


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

        //dd(config('filesystems.disks.s3.region'));
        
        //$imagePath = request('image')->store('uploads', 's3');

        $imagePath = request('image');

        $filePath = 'images/' . $imagePath->getClientOriginalName();

        
        Storage::disk('s3')->put($filePath, file_get_contents($imagePath), 'public');


        $contents = Storage::disk('s3')->get($filePath);        
        dd($contents);
        //upload to s3 working but opening does not
        
        //dd(storage_path("{$imagePath}"));

        //Storage::disk('s3')->setVisibility($imagePath, 'public');
        
        //dd($idk);

        //dd($imagePath);
        
        //Storage::disk('s3')->put($imagePath, file_get_contents($imagePath));

/*
        $image = Image::make([
            'filename' => basename($imagePath),
            'url' => Storage::disk('s3')->url($imagePath)
        ]);*/

        //dd(public_path("storage/{$imagePath}"));

        //$image = Image::make(public_path("storage/{$imagePath}"));
        //$image = Image::make($request->file('photo')->getRealPath());

        //$image->save();

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
