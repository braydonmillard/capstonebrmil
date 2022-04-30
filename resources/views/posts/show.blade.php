@extends('layouts.app')

@section('content')
<div class="container">
    <h3>{{ $post->title }}</h3><br>

    @can('update', $post->user->profile)
        <a href="/show/{{$post->id}}/edit">Edit Post</a>
        <br>
    @endcan

    @can('update', $post->user->profile)
        <a href="/delete/{{$post->id}}">Delete Post</a>
    @endcan

        <div class="row">
            <div class="col-6 offset-0">
            By <a href="/profile/{{ $post->user->id }}">
            {{ $post->user->username }} </a> <br>
            <i>{{ $post->caption }}</i>
            </div>
        </div>


        <div class="row col-6 offset-0"> @if(isset( $post->averaged_rating )) {{ $post->averaged_rating }} @else Not yet Rated @endif/5 </div>

        <div class="rating">
        @if (Auth::check())
            <a href="/rate/{{ $post->id }}/1"><i class="fa fa-star"></i></a>
            <a href="/rate/{{ $post->id }}/2"><i class="fa fa-star"></i></a>
            <a href="/rate/{{ $post->id }}/3"><i class="fa fa-star"></i></a>
            <a href="/rate/{{ $post->id }}/4"><i class="fa fa-star"></i></a>
            <a href="/rate/{{ $post->id }}/5"><i class="fa fa-star"></i></a>
        
        @else
            <a href="/login"><i class="fa fa-star"></i></a>
            <a href="/login"><i class="fa fa-star"></i></a>
            <a href="/login"><i class="fa fa-star"></i></a>
            <a href="/login"><i class="fa fa-star"></i></a>
            <a href="/login"><i class="fa fa-star"></i></a>

        @endif
        </div>

        <div>
        @if (Auth::check())
        <favourite :post="{{ $post->id }}" :favourited="{{ $post->favourited() ? 'true' : 'false' }} "></favourite>
        <a href="/addtomade/{{ $post->id }}" style="border-left: 1px solid #333333;" class="pl-1"> I made it</a>

        @else
        <a href="/login" style="border-left: 1px solid #333333;" class="pl-1"> I made it</a>        

        @endif
        </div>

        <div>
                <a href="/show/{{ $post->id }}">
                    <img src="https://brmil.s3.us-east-2.amazonaws.com/{{ $post->image }}" alight="right" class="w-75">
                </a>
            

            @if(Auth::check())
            @if(auth()->user()->is_admin)
                <a href="/feature/{{ $post->id }}">
                Feature Recipe
                </a>
            @endif
            @endif
            <div class="col-6 offset-0">
                <div>
                    <p>
                    <span class="font-weight-bold">
                    <h4>Ingredients</h4>
                    {{ $post->ingredients }}
                    </span> <br>
                        </a>
                    <h4>Directions</h4>
                    {{ $post->instructions }} <br><br>
        
        </div>
                    
                    <h4>Reviews</h4> 
                    
                    @if (empty($post->review->first()->comment))
                    There are no reviews yet
                    @else
                    @foreach($post->review as $review)
                    <strong>{{$review->username}}</strong> says <br>
                    {{$review->comment}}
                    <a href="/likereview/{{$review->id}}"i class="material-icons">thumb_up</i></a> <i>{{ $review->thumbs_up }} likes </i>           
                    <br> <br>
                    @endforeach
                    @endif
                    </p>

                    @if (Auth::check())
                    <form action="/review/{{$post->id}}" enctype="multipart/form-data" method="post">
                    
                    @else
                    <form action="/login" method="get">

                    @endif
                    @CSRF
                    <textarea id="review" name="review" rows="4" cols="50">Add a review </textarea>
                    
                    <button class="btn btn-primary">Submit</button>
                    </form>

                </div>
            </div>



        <div class="row">
            <div class="col-12 d-flex justify-content-center">
            </div>
        </div>
</div>
@endsection