<?php


namespace Solocode\Solorecipes\Controllers;

use App\Http\Controllers\Controller;
use Solocode\Solorecipes\Model\SoloRecipe;
use Illuminate\Http\Request;
use Solocode\Solorecipes\Model\SoloRecipeStep;

class SolorecipesController extends Controller
{

    public function index()
    {
        return view('solorecipes::recipes.solorecipes', [
            'recipes' => SoloRecipe::orderBy('created_at', 'asc')->get()
        ]);
    }

    public function viewRecipe($id){
        $p = SoloRecipe::findOrFail($id);
        return view('solorecipes::recipes.solorecipe', [
            'recipe' => $p
        ]);
    }

    public function createRecipe(){
        return view('solorecipes::recipes.createrecipe');
    }


    public function create(Request $request){
        $data = $request->all();

        $recipe = new SoloRecipe;
        $recipe->name = $data['name'];
        $steps = array();

        if ($request->hasFile('image')) {
            $path = $request->image->store('images','public');
            $recipe->image = $path;
        }

        foreach ($data['steps'] as $key => $step){
            $newstep = new SoloRecipeStep;
            $newstep->description = $step;
            $newstep->sortorder = $key;
            $steps[] = $newstep;
        }

        $recipe->save();

        $recipe->steps()->saveMany($steps);

        foreach ($data['ingredients'] as $key => $ingredient){
            $recipe->ingredients()->attach($ingredient,[
                'quantity' => $data['quantity'][$key],
                'preparation' => $data['preparation'][$key],
            ]);
        }

        return redirect('/recipes/'.$recipe->id);

    }

}
