@extends('layouts.app')

@section('content')
<div class="container">
    <h5><i>See what's cooking</i></h5><br>
<!--
    <h4>New from users you follow:</h4>
    @foreach($posts as $post)
        <div class="row">
            <div class="col-6 offset-3">
                <a href="/profile/{{ $post->user->id }}">
                    <img src="/storage/{{ $post->image }}" class="w-75">
                </a>
            </div>
        </div>
        <div class="row pt-2 pb-4">
            <div class="col-6 offset-3">
                <div>
                    <p>
                    <span class="font-weight-bold">
                        <a href="/profile/{{ $post->user->id }}">
                            <span class="text-dark">{{ $post->user->username }}</span>
                        </a>
                    </span> {{ $post->caption }}
                    </p>
                </div>
            </div>
        </div>
    @endforeach
-->
    <h4>New from all users:</h4>
    @foreach($posts as $post)
        <div class="row">
            <div class="col-6 offset-3">
                <a href="/show/{{ $post->id }}">
                    <img src="/storage/{{ $post->image }}" class="w-75">
                </a>
            </div>
        </div>
        <div class="row pt-2 pb-4">
            <div class="col-6 offset-3">
                <div>
                    <p>
                    <span class="font-weight-bold">
                    {{ $post->title }}
                    </span> <br>
                    <i>{{ $post->caption }}</i> <br>
                    By  <a href="/profile/{{ $post->user->id }}">
                            <span class="text-dark">{{ $post->user->username }}</span>
                        </a>
                    </p>
                </div>
            </div>
        </div>
    @endforeach


        <div class="row">
            <div class="col-12 d-flex justify-content-center">
            </div>
        </div>
</div>
@endsection