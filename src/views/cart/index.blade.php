@extends('solorecipes::layouts.app')

@section('content')
    <h2>Recipes</h2>
    <table class="table">
        <tbody>
        @foreach ($recipes as $recipe)
            <tr>
                <td><a href="{{url('/recipes/'.$recipe->id)}}">{{$recipe->name}}</a></td>
                <td><a href="{{url('/cart/remove/'.$recipe->id)}}">Remove</a></td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <h2>Grocery list</h2>
    <table class="table">
        <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Quantity</th>
            <th>Preparation</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($groceries as $ingredient)
            <tr>
                <td>{{$ingredient['row']}}</td>
                <td>{{$ingredient['name']}}</td>
                <td>{{$ingredient['quantity']}}</td>
                <td>{{$ingredient['measurement']}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection

@section('scripts')

@endsection