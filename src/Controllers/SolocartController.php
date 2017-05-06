<?php
/**
 * Created by PhpStorm.
 * User: wcorc
 * Date: 16/04/2017
 * Time: 7:21 PM
 */

namespace Solocode\Solorecipes\Controllers;

use App\Http\Controllers\Controller;
use Solocode\Solorecipes\Model\SoloIngredient;
use Illuminate\Http\Request;
use Solocode\Solorecipes\Model\SoloRecipe;

class SolocartController extends Controller
{
    public function viewCart(Request $request)
    {
        $recipes = self::getSessionRecipes();
        $recipes = SoloRecipe::all()->whereIn('id', $recipes);

        if (!empty($recipes)) {
            $shoppingList = array();
            $row = 0;
            foreach ($recipes as $recipe) {
                foreach ($recipe->ingredients as $ingredient) {
                    $key = $ingredient->id . '_' . $ingredient->pivot->measurement;
                    //{{$ingredient->name}} - {{$ingredient->pivot->quantity}} - {{$ingredient->pivot->preparation}}
                    if (!isset($shoppingList[$key])) {
                        ++$row;
                        $shoppingList[$key]['row'] = $row;
                        $shoppingList[$key]['name'] = $ingredient->name;
                        $shoppingList[$key]['quantity'] = $ingredient->pivot->quantity;
                        $shoppingList[$key]['measurement'] = $ingredient->pivot->measurement;
                    } else {
                        $shoppingList[$key]['quantity'] += $ingredient->pivot->quantity;
                    }
                }
            }
        }

        return view('solorecipes::cart.index', [
            'recipes' => $recipes,
            'groceries' => $shoppingList
        ]);
    }

    public function addToCar(Request $request)
    {
        if ($request->isMethod('post') && $request->ajax()) {
            $this->saveRecipeInSession($request->input('id'));
            return $request->input('id');
        }
    }

    public function removeFromCart(Request $request)
    {
        if ($request->isMethod('post') && $request->ajax()) {
            $this->removeRecipeFromSession($request->input('id'));
            return $request->input('id');
        }
    }

    public function remove(Request $request, $id)
    {
        $this->removeRecipeFromSession($id);
        return redirect('/recipes/cart');
    }

    public function getRecipesInCart(Request $request)
    {
        if ($request->ajax()) {
            $value = self::getSessionRecipes();
            return response()->json($value);
        }
    }

    private function saveRecipeInSession($recipeId)
    {
        $value = self::getSessionRecipes();

        $value[] = $recipeId;
        request()->session()->put('solorecipes', $value);
    }

    private function removeRecipeFromSession($recipeId)
    {
        $value = self::getSessionRecipes();
        if (!empty($value)) {
            $key = array_search($recipeId, $value);
            unset($value[$key]);
            request()->session()->put('solorecipes', $value);
        }

    }

    public static function getSessionRecipes()
    {
        return request()->session()->get('solorecipes', function () {
            return array();
        });
    }

}