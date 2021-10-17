@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-3 p-5">
        </div>
        <div class="col-9 pt-5">
            <div class="d-flex justify-content-between align-items-baseline">
                <div class="d-flex align-items-center pb-3">
                    <div class="h4">{{ $user->username }}</div>

                    <follow-button user-id="{{ $user->id }}" follows="{{ $follows }}"></follow-button><br>

                    <div class="pr-5"><strong>{{ $user->name }}</strong></div><br>


                    <div class="pr-5"><strong>{{ Auth::user()->following->count() }}</strong> following</div><br>
                    <div class="pr-5"><strong>{{ Auth::user()->followers }}</strong> followers</div><br>




                </div>

                @can('update', $user->profile)
                    <a href="/p/create">Add New Post</a>
                @endcan

            </div>

            @can('update', $user->profile)
                <a href="/profile/{{ $user->id }}/edit">Edit Profile</a>
            @endcan

            @can('update', $user->profile)
                <a href="/profile/{{ $user->id }}/edit">Edit Profile</a>
            @endcan

            <div class="d-flex">

            </div>
        </div>
    </div>

    <div class="row pt-5">
        @foreach($user->posts as $post)
            <div class="col-4 pb-4">
                <a href="/p/{{ $post->id }}">
                    <img src="/storage/{{ $post->image }}" class="w-100">
                </a>
            </div>
        @endforeach
    </div>
</div>
@endsection