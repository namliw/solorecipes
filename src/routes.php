<?php

//Route::get('recipes',
//  'Solocode\Solorecipes\Controllers\SolorecipesController@index');

//Product action routes
Route::group(['middleware' => ['web'],'prefix' => 'recipes'], function () {

    Route::get('/', 'Solocode\Solorecipes\Controllers\SolorecipesController@index');
    Route::get('/addRecipe', 'Solocode\Solorecipes\Controllers\SolorecipesController@createRecipe');
    Route::get('/{id}', 'Solocode\Solorecipes\Controllers\SolorecipesController@viewRecipe');
    Route::post('/create', 'Solocode\Solorecipes\Controllers\SolorecipesController@create');

});

Route::group(['middleware' => ['web'],'prefix' => 'ingredients'], function () {

    Route::get('/', 'Solocode\Solorecipes\Controllers\SoloingredientsController@listIngredients');
    Route::get('/search/{term}', 'Solocode\Solorecipes\Controllers\SoloingredientsController@search');

});
