<?php

Route::get('recipes/upload',
    'Solocode\Solorecipes\Controllers\SolorecipesController@uploadRecipe');
Route::post('recipes/upload',
    'Solocode\Solorecipes\Controllers\SolorecipesController@processRecipes');

//Product action routes
Route::group(['middleware' => ['web'], 'prefix' => 'recipes', 'namespace' => 'Solocode\Solorecipes\Controllers'], function () {
    Route::get('/', 'SolorecipesController@index');
    Route::get('/{recipe}', 'SolorecipesController@viewRecipe');
    //Route::get('/upload', 'SolorecipesController@uploadRecipe');
    Route::get('/addRecipe', 'SolorecipesController@createRecipe');
    Route::get('/{recipe}/edit/', 'SolorecipesController@editRecipe');

    //Route::post('/upload', 'SolorecipesController@processRecipes');
    Route::post('/create', 'SolorecipesController@create');
    Route::post('/{recipe}/edit/', 'SolorecipesController@edit');
});

Route::group(['middleware' => ['web'], 'prefix' => 'ingredients'], function () {
    Route::get('/', 'Solocode\Solorecipes\Controllers\SoloingredientsController@listIngredients');
    Route::get('/search/{term}', 'Solocode\Solorecipes\Controllers\SoloingredientsController@search');
});
