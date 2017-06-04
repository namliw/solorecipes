@extends('solorecipes::layouts.app')

@section('content')
    <h2>Mealplans</h2>
    @foreach ($plans as $plan)
        <div class="col-md-3">
            Plan created at {{$plan->created_at}} <br />
            <h5>Recipes in plan</h5>
            @foreach ($plan->recipes as $recipe)
                {{$recipe->name}} <br/>
            @endforeach
            <a href="{{ url('/mealplans/' .$plan->id ) }}">View plan</a>
        </div>
    @endforeach
@endsection

@section('scripts')

@endsection