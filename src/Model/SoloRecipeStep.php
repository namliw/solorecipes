<?php
/**
 * Created by PhpStorm.
 * User: wcorc
 * Date: 15/04/2017
 * Time: 3:40 PM
 */

namespace Solocode\Solorecipes\Model;
use Illuminate\Database\Eloquent\Model;

class SoloRecipeStep extends Model
{
    public function recipe(){
        return $this->belongsTo(SoloRecipe::class);
    }
}