@extends('solorecipes::layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <form class="form-horizontal" action="{{ url('recipes/upload') }}" method="POST"
                  enctype="multipart/form-data"
                  autocomplete="off">
                {{ csrf_field() }}
                <div clas="col-sm-12">
                    <h4>Recipe Upload</h4>
                </div>

                <div class="form-group">
                    <label class="col-lg-12 control-label">
                        Yaml File
                        <input type="file" name="yamlfile" value="" class="form-control"/>
                    </label>
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