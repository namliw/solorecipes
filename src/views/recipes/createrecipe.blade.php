@extends('solorecipes::layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <form class="col-sm-12" action="{{ $action }}" method="POST" enctype="multipart/form-data"
                  autocomplete="off">
                {{ csrf_field() }}
                <div clas="col-sm-12">
                    <h4>New Recipe</h4>
                </div>
                <label for="recipe-name" class="col-lg-12 control-label">
                    Name
                    <input type="text" name="name" id="recipe-name"
                           value="{{ old('name',  isset($recipe->name) ? $recipe->name : null) }}"
                           class="form-control"/>
                </label>
                <label for="recipe-image" class="col-lg-12 control-label">
                    Image
                    <input type="file" name="image" id="recipe-image" value="" class="form-control"/>
                </label>
                <div class="col-lg-12" id="app-4">
                    <h4>Ingredients</h4>
                    <div>
                        <input class="form-control" id="searchinput" type="search" placeholder="Search Ingredient...">
                        <div id="searchlist"></div>
                    </div>
                    <table class="table" width="80%" cellpadding="2">
                        <thead>
                        <tr>
                            <th></th>
                            <th>Name</th>
                            <th>Quantity</th>
                            <th>Preparation</th>
                            <th>&nbsp;</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(ingredient, key) in ingredients">
                            <td><input name="ingredients[]" type="hidden" v-bind:value="ingredient.id"></td>
                            <td>@{{ingredient.name}}</td>
                            <td><label class="control-label"><input type="text" class="form-control"
                                                                    v-bind:value="ingredient.quantity"
                                                                    name="quantity[]"></label></td>
                            <td><label class="control-label"><input type="text" class="form-control"
                                                                    v-bind:value="ingredient.preparation"
                                                                    name="preparation[]"></label></td>
                            <td><a v-on:click="removeElement(key)">Remove</a></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-lg-12" id="stepsContainer">
                    <h4>Preparation Steps</h4>
                    <div class="rows">
                        <div v-for="(step, key) in steps" class="col-md-4">
                            <div class="panel panel-default ">
                                <div class="panel-heading">Step @{{key + 1}}</div>
                                <div class="panel-body">
                                    <textarea rows="7" class="form-control" name="steps[]">@{{step.description}}</textarea><br/>
                                    <a v-on:click="removeElement(key)">Remove</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="panel panel-default"><a v-on:click="addStep()">Add Step</a></div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <button type="submit" class="btn">
                        <i class="fa fa-btn fa-plus"></i>Update product
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        var currIngredients = [
                @foreach ($recipe->ingredients as $ing)
            {
                id: '{{$ing->id}}',
                name: '{{$ing->name}}',
                quantity: '{{$ing->pivot->quantity}}',
                preparation: '{{$ing->pivot->preparation}}'
            },
            @endforeach
        ];
        var currSteps = [
                @foreach ($recipe->steps as $ing)
            {
                sortorder: '{{$ing->sortorder}}', description: '{{$ing->description}}'
            },
            @endforeach
        ];
    </script>
    <script src="https://unpkg.com/vue"></script>
    <link href="{{asset('/solocode/css/SoloRecipes.css')}}" rel="stylesheet" type="text/css">
    <script src="{{asset('/solocode/js/bootstrap-list-filter.min.js')}}"></script>
    <script src="{{asset('/solocode/js/SoloRecipes.create.js')}}"></script>
@endsection