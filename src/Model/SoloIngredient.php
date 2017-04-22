<?php
/**
 * Created by PhpStorm.
 * User: wcorc
 * Date: 15/04/2017
 * Time: 3:40 PM
 */

namespace Solocode\Solorecipes\Model;
use Illuminate\Database\Eloquent\Model;

class SoloIngredient extends Model
{
    protected $fillable = ['name'];

    public function recipes(){
        return $this->belongsToMany(SoloRecipe::class);
    }

    public function measurements(){
        return $this->belongsToMany(SoloMeasurement::class);
    }
}