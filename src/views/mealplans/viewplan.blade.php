@extends('solorecipes::layouts.app')

@section('content')
    <h2>Recipes</h2>
    <table class="table">
        <tbody>
        @foreach ($recipes as $recipe)
            <tr>
                <td><a href="{{url('/recipes/'.$recipe->id)}}">{{$recipe->name}}</a></td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <table class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Quantity</th>
                        <th>Measurement</th>
                        <th>Name</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($recipe->ingredients as $kry => $ingredient)
                        <tr>
                            <td>{{$kry + 1}}</td>
                            <td>{{$ingredient->pivot->quantity}}</td>
                            <td>{{$ingredient->pivot->measurement}}</td>
                            <td>{{$ingredient->name}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </tr>
        @endforeach
        </tbody>
    </table>
    <h2>Grocery list</h2>
    <table class="table">
        <thead>
        <tr>
            <th>#</th>
            <th>Quantity</th>
            <th>Measurement</th>
            <th>Name</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($groceries as $ingredient)
            <tr>
                <td>{{$ingredient['row']}}</td>
                <td>{{$ingredient['quantity']}}</td>
                <td>{{$ingredient['measurement']}}</td>
                <td>{{$ingredient['name']}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection

@section('scripts')

@endsection