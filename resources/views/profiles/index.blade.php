@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-3 p-5">
        <img src="{{ $user->profile->profileImage() }}" class="rounded-circle w-100">
        </div>
        <div class="col-9 pt-5">
            <div class="d-flex justify-content-between align-items-baseline">
                <div class="d-flex align-items-center pb-3">
                    <div class="h4">{{ $user->username }}</div>
                    @cannot('update', $user->profile)
                    <follow-button user-id="{{ $user->id }}" follows="{{ $follows }}"></follow-button>
                    @endcannot
                </div>

                @can('update', $user->profile)
                    <a href="/p/create">Add New Post</a>
                @endcan

            </div>



            @can('update', $user->profile)
                <a href="/profile/{{ $user->id }}/edit">Edit Profile</a>
            @endcan

            <div class="d-flex">
                <div class="pr-5"><strong>{{ $user->posts->count() }}</strong> posts</div>
            </div>
            <div class="pt-4 font-weight-bold">{{ $user->profile->title }}</div>
            <div>{{ $user->profile->description }}</div>
            <div><a href="#">{{ $user->profile->url }}</a></div>
        </div>
    </div>

    Personal recipes

    <div class="row pt-5">
        @foreach($user->posts as $post)
            <div class="col-4 pb-4">
                <a href="/show/{{ $post->id }}">
                    <img src="https://brmil.s3.us-east-2.amazonaws.com/{{ $post->image }}" class="w-100">
                </a>
                {{$post->title}}
                <favourite :post="{{ $post->id }}" :favourited="{{ $post->favourited() ? 'true' : 'false' }}"></favourite>
            </div>
        @endforeach
    </div>

    Favourites

    <div class="row pt-5">
        @foreach($user->favourites as $post)
            <div class="col-4 pb-4">
                <a href="/show/{{ $post->id }}">
                    <img src="https://brmil.s3.us-east-2.amazonaws.com/{{ $post->image }}" class="w-100">
                </a>
                {{$post->title}}
                <favourite post="{{ $post->id }}" favourited="{{ $post->favourited() ? 'true' : 'false' }}"></favourite>
            </div>
        @endforeach
    </div>

    Following


    @if($user->following()->first() !== null)
    {{$user->following()->get()->profileImage()}}
    @endif

    <div class="row pt-5">
        @foreach($user as $following)
            <div class="col-4 pb-4">
            </div>
        @endforeach
    </div>

</div>
@endsection