@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-3 p-5">
        <img src="https://brmil.s3.us-east-2.amazonaws.com/{{ $user->profile->profileImage() }}" class="rounded-circle w-100">
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
            <div>{{ $user->profile->description }}</div>
        </div>
    </div>

    <h3>Submitted recipes</h3>

    <div class="row pt-5">
        @foreach($user->posts as $post)
            <div class="col-4 pb-4">
                <a href="/show/{{ $post->id }}">
                    <img src="https://brmil.s3.us-east-2.amazonaws.com/{{ $post->image }}" class="w-100 h-75">
                </a>
                {{$post->title}}
                <favourite :post="{{ $post->id }}" :favourited="{{ $post->favourited() ? 'true' : 'false' }}"></favourite>
            </div>
        @endforeach
    </div>

    <h3>Favourites</h3>

    <div class="row pt-5">
        @foreach($user->favourites as $post)
            <div class="col-4 pb-4">
                <a href="/show/{{ $post->id }}">
                    <img src="https://brmil.s3.us-east-2.amazonaws.com/{{ $post->image }}" class="w-100 h-75">
                </a>
                {{$post->title}}
                <favourite post="{{ $post->id }}" favourited="{{ $post->favourited() ? 'true' : 'false' }}"></favourite>
            </div>
        @endforeach
    </div>

    <h3>Made Recipes</h3>

    <div class="row pt-5">
        @foreach($user->maderecipes as $post)
            <div class="col-4 pb-4">
                <a href="/show/{{ $post->id }}">
                    <img src="https://brmil.s3.us-east-2.amazonaws.com/{{ $post->image }}" class="w-100 h-75">
                </a>
                {{$post->title}}
                <favourite post="{{ $post->id }}" favourited="{{ $post->favourited() ? 'true' : 'false' }}"></favourite>
            </div>
        @endforeach
    </div>

    <h3>Following</h3>


    @if($user->following()->first() !== null)
    
    <div class="row pt-5">
        @foreach($user->following()->get() as $following)
            <div class="col-2 p-5">
            @if($following->image == null)
            <a href="/profile/{{ $following->id }}"><img src="https://brmil.s3.us-east-2.amazonaws.com/images/profile_image.png" class="rounded-circle w-100"></a>
            @else
            <a href="/profile/{{ $following->id }}"><img src="https://brmil.s3.us-east-2.amazonaws.com/{{$following->image}}" class="rounded-circle w-100"></a>
            @endif
            </div>
        @endforeach
    </div>
    @endif

    <h3>Followers</h3>

    @if($user->followers()->first() !== null)
    
    <div class="row pt-5">
        @foreach($user->followers()->get() as $follower)
            <div class="col-2 p-5">
            @if($follower->image == null)
            <a href="/profile/{{ $follower->id }}"><img src="https://brmil.s3.us-east-2.amazonaws.com/images/profile_image.png" class="rounded-circle w-100"></a>
            @else
            <a href="/profile/{{ $follower->id }}"><img src="https://brmil.s3.us-east-2.amazonaws.com/{{$follower->image}}" class="rounded-circle w-100"></a>
            @endif
            </div>
        @endforeach
    </div>
    @endif


</div>
@endsection