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
    <h4>Featured recipes:</h4>
    @foreach($posts as $post)
        @if($post->is_featured == '1')
        <div class="row">
            <div class="col-6 offset-3">
                <a href="/show/{{ $post->id }}">
                    <img src="https://brmil.s3.us-east-2.amazonaws.com/{{ $post->image }}" class="w-75">
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
        @endif
    @endforeach


    <h4>New from all users:</h4>
    @foreach($posts as $post)
        <div class="row">
            <div class="col-6 offset-3">
                <a href="/show/{{ $post->id }}">
                    <img src="https://brmil.s3.us-east-2.amazonaws.com/{{ $post->image }}" class="w-75">
                </a>
            </div>
        </div>
        <div class="row pt-2 pb-4">
            <div class="col-6 offset-3">
                <div>
                    <p>
                    <span class="font-weight-bold">
                    <a href="/show/{{ $post->id }}">
                    {{ $post->title }}
                    </a>
                    </span> <br>
                    <i>{{ $post->caption }}</i> <br>
                    By  <a href="/profile/{{ $post->user->id }}">
                            <span class="text-dark">{{ $post->user->username }}</span>
                        </a>
                    </p>
                    <favourite :post="{{ $post->id }}" :favourited="{{ $post->favourited() ? 'true' : 'false' }}"></favourite>
                </div>
            </div>
        </div>
    @endforeach


        <div class="row">
            <div class="col-12 d-flex justify-content-center">
            </div>
        </div>

    @if(Auth::check())
        @if(auth()->user()->is_admin)
        Hi admin
        @endif
    @endif

    Most searched for terms:

    @if($searchQueries->count() > 0)
    @foreach($searchQueries as $searchQuery)
        {{$searchQuery->query_text}}
        {{$searchQuery->timestamps}}
        <br>
    @endforeach
    @endif

    Most Favourited Recipes:


    <br>

    Most Prolific Recipe Makers:
    
    



</div>
@endsection