@extends('solorecipes::layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12">

            <div style="width: 200px; height: 200px; background: grey" id="pasteTarget">
                Click and paste here.
            </div>
            <form class="form-horizontal" action="{{ $action }}" method="POST" enctype="multipart/form-data"
                  autocomplete="off">
                {{ csrf_field() }}
                <fieldset>
                    <div clas="col-sm-12">
                        <h4>New Recipe</h4>
                    </div>
                    @include('solorecipes::partials.errors')
                    <div class="form-group">
                        <label for="recipe-name" class="col-lg-12 control-label">
                            Name
                            <input type="text" name="name" id="recipe-name"
                                   value="{{ old('name',  isset($recipe->name) ? $recipe->name : null) }}"
                                   class="form-control"/>
                        </label>
                    </div>

                    @if(isset($recipe->name) && $recipe->image)
                        <div class="form-group">
                            <label class="control-label">
                                Current Image
                                <img src="{{ Storage::disk()->url($recipe->image) }}">
                            </label>
                        </div>
                    @endif
                    <div class="form-group">
                        <label for="recipe-image" class="col-lg-12 control-label">
                            Image
                            <input type="file" name="image" id="recipe-image" value="" class="form-control"/>
                        </label>
                    </div>
                    <div class="form-group well" id="app-4">
                        <h4>Ingredients</h4>
                        <div>
                            <input class="form-control" id="searchinput" type="search"
                                   placeholder="Search Ingredient...">
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
                    <div class="form-group well" id="stepsContainer">
                        <h4>Preparation Steps</h4>
                        <div class="rows">
                            <div v-for="(step, key) in steps" class="col-md-4">
                                <div class="panel panel-default ">
                                    <div class="panel-heading">Step @{{key + 1}}</div>
                                    <div class="panel-body">
                                    <textarea rows="7" class="form-control"
                                              name="steps[]">@{{step.description}}</textarea><br/>
                                        <a v-on:click="removeElement(key)">Remove</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="panel panel-default"><a v-on:click="addStep()">Add Step</a></div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="pasteImage"/>

                    <div class="form-group">
                        <button type="submit" class="btn">
                            <i class="fa fa-btn fa-plus"></i>Update product
                        </button>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        var currIngredients = [
                @if(isset($recipe->name))
                @foreach ($recipe->ingredients as $ing)
            {
                id: '{{$ing->id}}',
                name: '{{$ing->name}}',
                quantity: '{{$ing->pivot->quantity}}',
                preparation: '{{$ing->pivot->preparation}}'
            },
            @endforeach
            @endif
        ];
        var currSteps = [
                @if(isset($recipe->name))
                @foreach ($recipe->steps as $ing)
            {
                sortorder: '{{$ing->sortorder}}', description: '{{$ing->description}}'
            },
            @endforeach
            @endif
        ];
        // Created by STRd6
        // MIT License
        // jquery.paste_image_reader.js
        (function ($) {
            var defaults;
            $.event.fix = (function (originalFix) {
                return function (event) {
                    event = originalFix.apply(this, arguments);
                    if (event.type.indexOf('copy') === 0 || event.type.indexOf('paste') === 0) {
                        event.clipboardData = event.originalEvent.clipboardData;
                    }
                    return event;
                };
            })($.event.fix);
            defaults = {
                callback: $.noop,
                matchType: /image.*/
            };
            return $.fn.pasteImageReader = function (options) {
                if (typeof options === "function") {
                    options = {
                        callback: options
                    };
                }
                options = $.extend({}, defaults, options);
                return this.each(function () {
                    var $this, element;
                    element = this;
                    $this = $(this);
                    return $this.bind('paste', function (event) {
                        var clipboardData, found;
                        found = false;
                        clipboardData = event.clipboardData;
                        return Array.prototype.forEach.call(clipboardData.types, function (type, i) {
                            var file, reader;
                            if (found) {
                                return;
                            }
                            if (type.match(options.matchType) || clipboardData.items[i].type.match(options.matchType)) {
                                file = clipboardData.items[i].getAsFile();
                                reader = new FileReader();
                                reader.onload = function (evt) {
                                    return options.callback.call(element, {
                                        dataURL: evt.target.result,
                                        event: evt,
                                        file: file,
                                        name: file.name
                                    });
                                };
                                reader.readAsDataURL(file);
//                                snapshoot();
                                return found = true;
                            }
                        });
                    });
                });
            };
        })(jQuery);

        $("html").pasteImageReader(function(results) {
            console.log(results.dataURL);
        });

    </script>
    <link href="{{asset('/solocode/css/SoloRecipes.css')}}" rel="stylesheet" type="text/css">
    <script src="{{asset('/solocode/js/bootstrap-list-filter.min.js')}}"></script>
    <script src="{{asset('/solocode/js/SoloRecipes.create.js')}}"></script>
@endsection