@extends('layouts.app')

@section('content')
<div class="container">
    <h3>{{ $post->title }}</h3><br>

        <div class="row">
            <div class="col-6 offset-0">
            By {{ $post->user->username }} <br>
            {{ $post->caption }}
                <a href="/p/{{ $post }}">
                </a>
            </div>
        </div>

        <div class="col-6 offset-7">
                <a href="/show/{{ $post->id }}">
                    <img src="/storage/{{ $post->image }}" class="w-75">
                </a>
            </div>

        <div class="row pt-2 pb-4">
            <div class="col-6 offset-0">
                <div>
                    <p>
                    <span class="font-weight-bold">
                    <h4>Ingredients</h4>
                    {{ $post->title }}
                    </span> <br>
                        </a>
                    <h4>Directions</h4>
                    {{ $post->instructions }} Instructions go here
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