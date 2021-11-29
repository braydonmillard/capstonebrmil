@extends('layouts.app')

@section('content')
<div class="container">
    <h3>{{ $post->title }}</h3><br>

        <div class="row">
            <div class="col-6 offset-0">
            By <a href="/profile/{{ $post->user->id }}">
            {{ $post->user->username }} </a> <br>
            {{ $post->caption }}
            </div>
        </div>

        <div class="row"> {{ $post->rating }}/5 </div>

        <div class="rating">
            <a href="/rate/{{ $post->id }}"><i class="fa fa-star" > </i></a>
            <a href="/profile/{{ $post->user->id }}"><i class="fa fa-star" > </i></a>
            <a href="/profile/{{ $post->user->id }}"><i class="fa fa-star" > </i></a>
            <a href="/profile/{{ $post->user->id }}"><i class="fa fa-star" > </i></a>
            <a href="/profile/{{ $post->user->id }}"><i class="fa fa-star" > </i></a>
        </div>

        <div class="col-6 offset-7">
                <a href="/show/{{ $post->id }}">
                    <img src="https://brmil.s3.us-east-2.amazonaws.com/{{ $post->image }}" class="w-75">
                </a>
            </div>

            @if(Auth::check())
            @if(auth()->user()->is_admin)
                <a href="/feature/{{ $post->id }}">
                Feature Recipe
                </a>
            @endif
            @endif
        <div class="row pt-2 pb-4">
            <div class="col-6 offset-0">
                <div>
                    <p>
                    <span class="font-weight-bold">
                    <h4>Ingredients</h4>
                    {{ $post->ingredients }}
                    </span> <br>
                        </a>
                    <h4>Directions</h4>
                    {{ $post->instructions }} <br>
                    <h4>Reviews</h4>
                    @if (empty($post->review->first()->comment))
                    There are no reviews yet
                    @else
                    {{$post->review->first()->comment}}
                    @endif
                    </p>
                </div>
            </div>
        </div>



        <div class="row">
            <div class="col-12 d-flex justify-content-center">
            </div>
        </div>
</div>
@endsection