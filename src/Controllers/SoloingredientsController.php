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

class SoloingredientsController extends Controller
{
    public function listIngredients(Request $request){
        return response()->json([
            'data' => SoloIngredient::orderBy('name', 'asc')->get()
        ]);
    }

    public function search(Request $request, $term){
        return response()->json(SoloIngredient::orderBy('name', 'asc')->where('name','like','%'.$term.'%')->get());
    }

}