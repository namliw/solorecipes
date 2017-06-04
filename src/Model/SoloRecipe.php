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
            ->withPivot('quantity', 'preparation', 'measurement');
    }

    public function addStep(SoloRecipeStep $step)
    {
        $this->steps()->save($step);
    }

    public function addSteps($steps)
    {
        $this->steps()->saveMany($steps);
    }

    public function addIngredient(SoloIngredient $ingredient, $preparation, $quantity = 1, $measurement = 'grams')
    {
        $this->ingredients()->attach($ingredient, [
            'quantity' => $quantity,
            'preparation' => $preparation,
            'measurement' => $measurement,
        ]);
    }

    public function addIngredientByName($ingredient, $preparation, $quantity = 1, $measurement = 'grams')
    {
        $ingredient = trim($ingredient);
        //Find ingredient or create if it doesnt exist
        $ingredient = SoloIngredient::firstOrCreate(['name' => $ingredient]);
        $this->addIngredient($ingredient, $preparation, $quantity, $measurement);
    }

    static public function createFromYaml($yamlEntry)
    {
        $yamlEntry = (object)$yamlEntry;
        $recipe = SoloRecipe::where('name', '=', trim($yamlEntry->Name))->first();
        if ($recipe === null) {
            $recipe = SoloRecipe::create(['name' => trim($yamlEntry->Name)]);

            $steps = array();
            foreach ($yamlEntry->Steps as $key => $step) {
                $newstep = new SoloRecipeStep;
                $newstep->description = trim($step);
                $newstep->sortorder = $key;
                $steps[] = $newstep;
            }

            $recipe->addSteps($steps);

            foreach ($yamlEntry->Ingredients as $ingredient) {
                $recipe->addIngredientByName($ingredient->Name,
                    $ingredient->Preparation, $ingredient->Quantity, $ingredient->Measurement);
            }
        }

        return $recipe;
    }
}