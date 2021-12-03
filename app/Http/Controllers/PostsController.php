<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\SearchQuery;
use App\Models\Rating;
use App\Models\Favourite;
use App\Models\User;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Auth;
use DB;
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

        $searchQueries = SearchQuery::all();

        $queriesGrouped = DB::table('search_queries')
                            ->select('query_text', DB::raw('count(*) as total'))
                            ->groupBy('query_text')
                            ->orderBy('total', 'desc')
                            ->get();

        $postsGrouped = DB::table('posts')
                            ->select('*')
                            ->orderBy('times_favourited', 'desc')
                            ->get();

        $usersGrouped = DB::table('posts')
                            ->select('user_id', DB::raw('count(*) as total'))
                            ->groupBy('user_id')
                            ->orderBy('total', 'desc')
                            ->get();

        //return view('posts.index', compact('posts', 'allposts'));
        return view('posts.index', compact('posts', 'searchQueries', 'queriesGrouped', 'usersGrouped', 'postsGrouped'));
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


        //Wow it seems to work


        //$contents = Storage::disk('s3')->get($filePath);        
        //dd($contents);
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
            'image' => $filePath,    
        ]);

        return redirect('/profile/' . auth()->user()->id);
    }

    public function search(Request $request){
        $search_text = $_GET['query'];

        /*$query = Post::query();

        if ($s = $request->input('s')) {
            $query->whereRaw("title LIKE '%'. $s .'%' ");
        }*/
        SearchQuery::create([ 'query_text' => $search_text,
        ]);



        if ($request->sort == "Newest")
        {
            $posts = Post::where('title', 'LIKE', '%'.$search_text.'%')->orderBy('id', 'desc')->get();
        }
        else if($request->sort == "Most_Popular")
        {
            $posts = Post::where('title', 'LIKE', '%'.$search_text.'%')->orderBy('id', 'desc')->get();
        }
        else
        {
        $posts = Post::where('title', 'LIKE', '%'.$search_text.'%')->get();
        }



        //if ($request->sort == "post_latest"){
        //    $posts->orderBy('id', 'desc');
        //}


        //$posts = $posts->get();

        //dd($posts);

        //dd($request->sort);
            /*
        if ($sort = $request->input('sort')) {
            $query->orderBy('id', 'desc', $sort);
        }*/

        return view('posts.search',compact('posts', 'search_text'));
        //return $query->get();
    }

    public function sort(){
        //$search_text = $searchText;

        $posts = Post::latest()->get();

        return view('posts.search',compact('posts'));
    }

    public function rate(Post $post, Request $request){
        //$search_text = $searchText;

        //If user gives invalid rating value, ignore and return to page
        if($request->rating > 5 || $request->rating < 1){
            return back();
        }

        //dd(auth()->user()->id);

        /*
            Just divide sum of ratings by count
        */
        
        $ratings = $post->Rating;

        //dd($ratings);

        //$ratings->avg

        //dd($post->Rating->first());
        //dd(contains($user->id)
        //round(avgRating, 1);
        
        
        //User can only rate post once
        if($ratings->contains('user_id', auth()->user()->id)){
            echo("You have already rated this post");
            return back();
        }

        //dd(Rating::all());
        
        //if(Post::find($post->id))

        //dd($request->rating);

        $myRating = Rating::create([ 
        'post_id' => $post->id,
        'rating' => $request->rating,
        'user_id' => auth()->user()->id,
        ]);
        //$posts = Post::latest()->get();

        //$avgRating = round(Rating::avg('rating'), 1);

        //dd($avgRating);

        $ratingArray = $post->rating->pluck('rating');
        
        //dd(count($ratingArray->all()));

        //dd(array_sum($ratingArray->all()));

        $avgRating = array_sum($ratingArray->all()) / count($ratingArray->all());

        //dd(round($avgRating, 1));

        $avgRating = round($avgRating, 1);

        $myPost = Post::find($post->id);

        $myPost->update(['averaged_rating' => $avgRating]);

        //Set average rating field for post

        //$myPost->rating

        //$myPost->rating()->attach($myRating);

        //dd($myPost->rating);

        return view('posts.show', compact('post', 'avgRating'));
        //return Post::find($post->id);
        //return back();
        //return redirect()->route('posts');
    }

    public function feature(Post $post){
        //$search_text = $_GET['query'];

        //$posts = Post::where('title', 'LIKE', '%'.$search_text.'%')->get();

        //$post->is_featured=1;

        //return view('posts.show', compact('post'));

        $myPost = Post::find($post->id);

        $myPost->update(['is_featured' => 1]);

        return Post::find($post->id);
    }

    public function favouritePost(Post $post)
    {
        //alert('test test test');
        //$myPost = Post::find($post->id);

        //$myPost->update(['times_favourited' => 1]);

    
    Auth::user()->favourites()->attach($post->id);

    //alert('test test test');


    //dd($post);
    console.log('Post favourited!');



    //dd(auth()->user()->favourites());

    return back();
    }

    public function unFavouritePost(Post $post)
    {
    Auth::user()->favourites()->detach($post->id);

    return back();
    }

}
