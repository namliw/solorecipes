<?php


namespace Solocode\Solorecipes\Controllers;

use App\Http\Controllers\Controller;
use Solocode\Solorecipes\Model\SoloMealplan;

class MealplanController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function listPlans(){
        return view('solorecipes::mealplans.index', [
            'plans' => SoloMealplan::orderBy('created_at', 'desc')->get()
        ]);
    }

    public function view(SoloMealplan $mealplan){
        $recipes = $mealplan->recipes;

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

        return view('solorecipes::mealplans.viewplan', [
            'recipes' => $recipes,
            'groceries' => $shoppingList
        ]);
    }

}
