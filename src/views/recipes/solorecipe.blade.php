@extends('solorecipes::layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h1>{{ $recipe->name }}</h1>
            @if(!empty($recipe->image))
                <img src="{{ Storage::disk()->url($recipe->image) }}">
            @endif
            <a href="{{url('/recipes/'.$recipe->id.'/edit')}}">edit</a>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <h4>Ingredients</h4>
        </div>
        @foreach ($recipe->ingredients as $ingredient)
            <div class="col-md-3">
                {{$ingredient->name}} - {{$ingredient->pivot->quantity}} - {{$ingredient->pivot->preparation}}
            </div>
        @endforeach
    </div>
    <div class="row">
        <div class="col-lg-12">
            <h4>Preparation</h4>
        </div>
        @foreach ($recipe->steps as $key => $step)
            <div class="col-md-3">
                <h5>Step {{$key + 1}}</h5>
                {!! $step->description !!}
            </div>
        @endforeach
    </div>
@endsection