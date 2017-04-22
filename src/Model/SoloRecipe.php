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
    protected $fillable = ['name', 'image'];

    public function steps()
    {
        return $this->hasMany(SoloRecipeStep::class);
    }

    public function ingredients()
    {
        return $this->belongsToMany(SoloIngredient::class)
            ->withPivot('quantity', 'preparation');
    }

    public function addStep(SoloRecipeStep $step)
    {
        $this->steps()->save($step);
    }

    public function addSteps($steps)
    {
        $this->steps()->saveMany($steps);
    }

    public function addIngredient(SoloIngredient $ingredient, $preparation, $quantity = 1)
    {
        $this->ingredients()->attach($ingredient, [
            'quantity' => $quantity,
            'preparation' => $preparation,
        ]);
    }
}