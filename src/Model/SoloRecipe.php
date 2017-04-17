<?php
/**
 * Created by PhpStorm.
 * User: wcorc
 * Date: 15/04/2017
 * Time: 3:39 PM
 */

namespace Solocode\Solorecipes\Model;
use Illuminate\Database\Eloquent\Model;

class SoloRecipe extends Model
{
    public function steps()
    {
        return $this->hasMany(SoloRecipeStep::class,'solorecipes_id');
    }

    public function ingredients(){
        return $this->belongsToMany(SoloIngredient::class,'solorecipes_soloingredients','solorecipes_id','soloingredients_id')
            ->withPivot('quantity', 'preparation');
    }
}