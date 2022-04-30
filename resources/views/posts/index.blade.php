@extends('layouts.app')

@section('content')
<div class="container">
    <h5><i>See what's cooking</i></h5><br>

    <h4>Featureeed recipes:</h4>
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

        <div class="row">
            <div class="col-12 d-flex justify-content-center">
            </div>
        </div>

    @if(Auth::check())
        @if(auth()->user()->is_admin)
        <h2>Site Metrics</h2>
        

    Most searched for terms:

    @if($searchQueries->count() > 0)
    <table>
        <tr>
            <th> Query </th>
            <th> Times Searched </th>
        </tr>
    @foreach($queriesGrouped as $searchQuery)
        <tr>
            <td> {{$searchQuery->query_text}} </td>
            <td> {{$searchQuery->total}} </td>
        </tr>
    @endforeach
    </table>
    @endif <br><br>

    Most Favourited Recipes:
    <table>
        <tr>
            <th> Recipe Name </th>
            <th> Times Favourited </th>
        </tr>
    @foreach($postsGrouped as $postt)
        <tr>
            <td> {{$postt->title}}</td>
            <td> {{$postt->times_favourited}} </td>
        </tr>
    @endforeach
    </table>

    <br><br>

    Most Prolific Recipe Uploaders:
    <table>
        <tr>
            <th> User Id </th>
            <th> Recipes Uploaded </th>
        </tr>
    @foreach($usersGrouped as $user)
        <tr>
            <td> <a href="/profile/{{ $user->user_id }}">{{$user->user_id}} </a></td>
            <td> {{$user->total}} </td>
        </tr>
    @endforeach
    </table>

    @endif
    @endif
    



</div>
@endsection