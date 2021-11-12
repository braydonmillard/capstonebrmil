@extends('layouts.app')

@section('content')
<div class="container">


<h5>{{count($posts)}} recipes found for "{{$search_text}}":

<div class="form-group col-6 offset-8">
<form action="{{ url('/search') }}" type="get">
<label for="sort">Sort by: </label>
    <select name="sort" id="sort">
     <option value="Best Match">Best Match (Default)</option>
     <option value="Newest">Newest</option>
     <option value="Most Popular">Most Popular</option>
    </select>
    <input type="hidden" name="query" value="" />
</form>
</div>
</h5>

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
                </div>
            </div>
        </div>

@endforeach
</div>
@endsection