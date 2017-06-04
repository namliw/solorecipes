<?php

namespace Solocode\Solorecipes\Model;

use Illuminate\Database\Eloquent\Model;

class SoloMealplan extends Model
{
    public function recipes()
    {
        return $this->belongsToMany(SoloRecipe::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
