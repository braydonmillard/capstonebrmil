<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\SearchQuery;
use App\Models\Rating;
use App\Models\Favourite;
use App\Models\Review;
use App\Models\User;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Auth;
use DB;
use Storage;

require('../vendor/autoload.php');


class PostsController extends Controller
{
    public function __construct(){

    }

    public function index(){

        $posts = Post::latest()->limit(100)->get();

        $searchQueries = SearchQuery::all();

        $queriesGrouped = DB::table('searchqueries')
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

        $imagePath = request('image');

        $filePath = 'images/' . $imagePath->getClientOriginalName();

        
        Storage::disk('s3')->put($filePath, file_get_contents($imagePath), 'public');

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

        SearchQuery::create([ 'query_text' => $search_text,
        ]);

        if ($request->sort == "Newest")
        {
            $posts = Post::where('title', 'ILIKE', '%'.$search_text.'%')->orderBy('id', 'desc')->get();
        }
        else if($request->sort == "Most_Popular")
        {
            $posts = Post::where('title', 'ILIKE', '%'.$search_text.'%')->orderBy('times_made', 'desc')->get();
        }
        else
        {
        $posts = Post::where('title', 'ILIKE', '%'.$search_text.'%')->get();
        }

        return view('posts.search',compact('posts', 'search_text'));
    }

    public function sort(){

        $posts = Post::latest()->get();

        return view('posts.search',compact('posts'));
    }

    public function rate(Post $post, Request $request){

        //If user gives invalid rating value, ignore and return to page
        if($request->rating > 5 || $request->rating < 1){
            return back();
        }
        
        $ratings = $post->Rating;
        
        //User can only rate post once
        if($ratings->contains('user_id', auth()->user()->id)){
            return view('posts.show', compact('post'));
        }

        $myRating = Rating::create([ 
        'post_id' => $post->id,
        'rating' => $request->rating,
        'user_id' => auth()->user()->id,
        ]);

        $ratingArray = $post->rating->pluck('rating');
        

        $avgRating = array_sum($ratingArray->all()) / count($ratingArray->all());


        $avgRating = round($avgRating, 1);

        $myPost = Post::find($post->id);

        $post->update(['averaged_rating' => $avgRating]);

        return view('posts.show', compact('post'));
    }

    public function feature(Post $post)
    {
        $myPost = Post::find($post->id);

        $myPost->update(['is_featured' => 1]);

        return Post::find($post->id);
    }

    public function favouritePost(Post $post)
    {
        $times_favourited = $post->times_favourited;

        $times_favourited++;

        $post->update(['times_favourited' => $times_favourited]);

        Auth::user()->favourites()->attach($post->id);

        console.log('Post favourited!');

        return back();
    }

    public function unFavouritePost(Post $post)
    {
        $times_favourited = $post->times_favourited;

        $times_favourited--;

        $post->update(['times_favourited' => $times_favourited]);
        
        Auth::user()->favourites()->detach($post->id);

        return back();
    }

    public function addToMade(Post $post)
    {
        $times_made = $post->times_made;

        $times_made++;

        $post->update(['times_made' => $times_made]);

        Auth::user()->made_Recipes()->attach($post->id);
        
        return back();
    }

    public function review(Post $post, Request $request)
    {        
        $myReview = Review::create([ 
            'post_id' => $post->id,
            'comment' => $request->review,
            'user_id' => auth()->user()->id,
            'username' => auth()->user()->username,
            ]);
        
        
        return view('posts.show', compact('post'));
    }

    public function likereview(Review $review)
    {        
        $times_liked = $review->thumbs_up;

        $times_liked++;

        $review->update(['thumbs_up' => $times_liked]);
        
        return back();
    }

    public function edit(Post $post)
    {
        if(auth()->user()->id == $post->user_id){
        return view('posts.edit', compact('post'));
        }

        return redirect("/");
    }

    public function update(Post $post)
    {
        if(auth()->user()->id == $post->user_id){

        $data = request()->validate([
            'title' => 'required',
            'caption' => 'required',
            'ingredients' => 'required',
            'instructions' => 'required',
            'image' => '',
        ]);

        if (request('image')) {
            
        $imagePath = request('image');

        $filePath = 'images/' . $imagePath->getClientOriginalName();

        Storage::disk('s3')->put($filePath, file_get_contents($imagePath), 'public');

            $imageArray = ['image' => $filePath];
        }

        $post->update(array_merge(
            $data,
            $imageArray ?? []
        ));
        }

        return redirect("/show/{$post->id}");
    }

    public function delete(Post $post)
    {
        $this->authorize('update', auth()->user()->profile);

        if(auth()->user()->id == $post->user_id){
            $post->delete();
        }

        return redirect("/");
    }

}
