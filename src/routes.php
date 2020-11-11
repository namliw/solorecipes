<?php
// This is a random commit
//Product action routes
Route::group(['middleware' => ['web'], 'prefix' => 'recipes', 'namespace' => 'Solocode\Solorecipes\Controllers'], function () {
    //Note to self, laravel has a strange bug where the order of the routes matter....
    //Put all routes with params at the bottom
    Route::get('/', 'SolorecipesController@index');
    Route::post('/create', 'SolorecipesController@create');
    Route::get('/upload', 'SolorecipesController@uploadRecipe');
    Route::post('/upload', 'SolorecipesController@processRecipes');
    Route::get('/cart', 'SolocartController@viewCart');
    Route::get('/cart/saveplan', 'SolocartController@savePlan');
    //Route::get('/upload', 'SolorecipesController@uploadRecipe');
    Route::get('/addRecipe', 'SolorecipesController@createRecipe');
    Route::get('/{recipe}', 'SolorecipesController@viewRecipe');
    Route::get('/{recipe}/edit/', 'SolorecipesController@editRecipe');

    //Route::post('/upload', 'SolorecipesController@processRecipes');
    Route::post('/{recipe}/edit/', 'SolorecipesController@edit');
    Route::post('/{recipe}/editimage/', 'SolorecipesController@imageUpload');

});
// This is another commit
Route::group(['middleware' => ['web'], 'prefix' => 'ingredients'], function () {
    Route::get('/', 'Solocode\Solorecipes\Controllers\SoloingredientsController@listIngredients');
    Route::get('/search/{term}', 'Solocode\Solorecipes\Controllers\SoloingredientsController@search');
});

Route::group(['middleware' => ['web'], 'prefix' => 'cart', 'namespace' => 'Solocode\Solorecipes\Controllers'], function () {
    Route::get('/getRecipesInCart', 'SolocartController@getRecipesInCart');
    Route::post('/addToCar', 'SolocartController@addToCar');
    Route::post('/removeFromCart', 'SolocartController@removeFromCart');
    Route::get('/remove/{id}', 'SolocartController@remove');
});

Route::group(['middleware' => ['web'], 'prefix' => 'mealplans', 'namespace' => 'Solocode\Solorecipes\Controllers'], function () {
    Route::get('/', 'MealplanController@listPlans');
    Route::get('/{mealplan}', 'MealplanController@view');

});