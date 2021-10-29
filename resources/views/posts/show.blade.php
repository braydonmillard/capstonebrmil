@extends('layouts.app')

@section('content')
<div class="container">
    <h5><i>This recipe:</i></h5><br>

        <div class="row">
            <div class="col-6 offset-3">
                <a href="/p/{{ $post }}">
                </a>
            </div>
        </div>

        <div class="col-6 offset-3">
                <a href="/show/{{ $post->id }}">
                    <img src="/storage/{{ $post->image }}" class="w-75">
                </a>
            </div>

        <div class="row pt-2 pb-4">
            <div class="col-6 offset-3">
                <div>
                    <p>
                    <span class="font-weight-bold">
                    {{ $post->title }}
                    </span> <br>
                        </a>
                    {{ $post->instructions }}
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