@extends('layouts.app')

@section('content')
<div class="container">


<h5>{{count($posts)}} recipes found for "{{$search_text}}":

<div class="form-group col-6 offset-8">
<form action="{{ url('/search') }}" type="get">
<label for="sort">Sort by: </label>
    <select name="sort" id="sort">
     <option value="Best_Match">Best Match (Default)</option>
     <option value="Newest">Newest</option>
     <option value="Most_Popular">Most Popular</option>
    </select>
    <input type="hidden" name="query" value="{{ $search_text }}"/>
    <button type="submit" value="Submit">Sort</button>
</form>
</h5>
<br>
<!--
<style>
    .post-favourite{
        position: absolute;
        top:10%;
        left:0;
        z-index:99;
        right:30px;
        text-align:right;
        padding-top:0;
    }
    .post-favourite .fa{
        color:#cbcbcb;
        font-size:32px;
    }
    .post-favourite .fa:hover{
        color:#ff7007;
    }
</style>
-->

@foreach($posts as $post)

<div class="row">
            <div class="col-6 offset-3">
                <a href="/show/{{ $post->id }}">
                    <img src="https://brmil.s3.us-east-2.amazonaws.com/{{ $post->image }}" class="square">
                </a>
            </div>
        </div>
        <div class="row pt-2 pb-4">
            <div class="col-6 offset-3">
                <div>
                    
                    <span class="font-weight-bold">
                    <a href="/show/{{ $post->id }}">
                    {{ $post->title }}
                    </a>
                    </span> <br>
                    <i>{{ $post->caption }}</i> <br>
                    By  <a href="/profile/{{ $post->user->id }}">
                            <span class="text-dark">{{ $post->user->username }}</span>
                        </a> <br>
                        @if (Auth::check())
                            <div>
                                <favourite post="{{ $post->id }}" favourited="{{ $post->favourited() ? 'true' : 'false' }}"></favourite>
                            </div>
                        @endif

                    </div>
                
                </div>
            </div>
        </div>
</div>
</div>

@endforeach
@endsection