<div class="col-sm-4 col-md-3">
    <div class="panel panel-default">
        @if(!empty($recipe->image))
            <div class="panel-body">
                <img src="{{ Storage::disk()->url($recipe->image) }}" width="100%">
            </div>
        @endif

        <div class="panel-footer"><a href="{{url('/recipes/'.$recipe->id)}}">{{ $recipe->name }}</a></div>
    </div>
</div>