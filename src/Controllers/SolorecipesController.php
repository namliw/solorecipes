<?php


namespace Solocode\Solorecipes\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
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

    public function viewRecipe(SoloRecipe $recipe)
    {
        return view('solorecipes::recipes.solorecipe', compact('recipe'));
    }

    public function createRecipe()
    {
        return view('solorecipes::recipes.createrecipe',[
            'action' => url('recipes/create')
        ]);
    }

    public function editRecipe(SoloRecipe $recipe)
    {
        return view('solorecipes::recipes.createrecipe', [
            'recipe' => $recipe,
            'action' => url('recipes/'.$recipe->id.'/edit')
        ]);
    }


    public function create(Request $request)
    {
        $this->validate($request,[
            'name' => 'required',
            'steps' => 'required',
            'ingredients' => 'required',
        ]);

        $data = $request->all();

        $recipe = new SoloRecipe;
        $recipe->name = $data['name'];
        $steps = array();

        if ($request->hasFile('image')) {
            $path = $request->image->store('images', 'public');
            $recipe->image = $path;
        }

        foreach ($data['steps'] as $key => $step) {
            $newstep = new SoloRecipeStep;
            $newstep->description = $step;
            $newstep->sortorder = $key;
            $steps[] = $newstep;
        }

        $recipe->save();

        $recipe->steps()->saveMany($steps);

        foreach ($data['ingredients'] as $key => $ingredient) {
            $recipe->ingredients()->attach($ingredient, [
                'quantity' => $data['quantity'][$key],
                'preparation' => $data['preparation'][$key],
            ]);
        }

        return redirect('/recipes/' . $recipe->id);

    }

    public function edit(Request $request, SoloRecipe $recipe)
    {
        $data = $request->all();
        //$recipe = SoloRecipe::findOrFail($id);

        if ($recipe->name != $data['name']) {
            $recipe->name = $data['name'];
        }

        $steps = array();

        if ($request->hasFile('image')) {
            Storage::delete($recipe->image);
            $path = $request->image->store('images', 'public');
            $recipe->image = $path;
        }

        $recipe->steps()->delete();

        foreach ($data['steps'] as $key => $step) {
            $newstep = new SoloRecipeStep;
            $newstep->description = $step;
            $newstep->sortorder = $key;
            $steps[] = $newstep;
        }

        $recipe->save();

        $recipe->steps()->saveMany($steps);

        $ingData = array();
        foreach ($data['ingredients'] as $key => $ingredient) {
            $ingData[$ingredient] =
                [
                    'quantity' => $data['quantity'][$key],
                    'preparation' => $data['preparation'][$key],
                ];
        }
        $recipe->ingredients()->sync($ingData);

        return redirect('/recipes/' . $recipe->id);

    }

}
