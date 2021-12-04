@extends('layouts.app')

@section('content')
<div class="container">
    <form action="/show/{{ $post->id }}" enctype="multipart/form-data" method="post">
        @csrf
        @method('PATCH')

        <div class="row">
            <div class="col-8 offset-2">

                <div class="row">
                    <h1>Edit Recipe</h1>
                </div>
                <div class="form-group row">
                            <label for="title" class="col-md-4 col-form-label">Recipe Title</label>

                                <input id="title" 
                                type="text" 
                                class="form-control @error('title') is-invalid @enderror" 
                                name="title"
                                value="{{ old('title') }}" 
                                autocomplete="title" autofocus>

                                @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>

            <div class="form-group row">
                            <label for="caption" class="col-md-4 col-form-label">Recipe Description</label>

                                <textarea id="caption" 
                                class="form-control @error('caption') is-invalid @enderror" 
                                name="caption" rows="4" cols="50"></textarea>


                                @error('caption')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>

            <div class="form-group row">
                            <label for="ingredients" class="col-md-4 col-form-label">Recipe Ingredients</label>

                                <textarea id="ingredients" 
                                class="form-control @error('ingredients') is-invalid @enderror" 
                                name="ingredients" rows="4" cols="50"></textarea>

                                @error('ingredients')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>

            <div class="form-group row">
                            <label for="instructions" class="col-md-4 col-form-label">Recipe Instructions</label>

                                <textarea id="instructions" 
                                class="form-control @error('instructions') is-invalid @enderror" 
                                name="instructions" rows="4" cols="50"></textarea>

                                @error('instructions')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>

                        <div class="row">
                            <label for="image" class="col-md-4 col-form-label">Recipe Image</label>
                            <input type="file" class="form-control-file" id="image" name="image">

                            @error('image')
                                    <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>

                <div class="row pt-4">
                    <button class="btn btn-primary">Save Recipe</button>
                </div>

            </div>
        </div>
    </form>
</div>
@endsection