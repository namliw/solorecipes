@extends('solorecipes::layouts.app')

@section('content')
    <div class="jumbotron">
        <h1>Solo Recipes</h1>
        <p>This is a collection of simple recipes for my weekly meal plan.</p>
    </div>
    <div class="row">
        @foreach ($recipes as $recipe)
            <div class="col-md-3">
                <a href="{{url('/recipes/'.$recipe->id)}}">{{ $recipe->name }}</a>
            </div>
        @endforeach
    </div>
@endsection