<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecipesIngredientsStepsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solo_recipes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('image')->nullable();
            $table->timestamps();
        });

        Schema::create('solo_ingredients', function (Blueprint $table) {
            $table->increments('id');
            $table->text('name');
            $table->timestamps();
        });

        Schema::create('solo_ingredient_solo_recipe', function (Blueprint $table) {
            $table->integer('solo_recipe_id')->unsigned()->nullable();
            $table->integer('solo_ingredient_id')->unsigned()->nullable();

            $table->foreign('solo_recipe_id')->references('id')
                ->on('solo_recipes')->onDelete('cascade');
            $table->foreign('solo_ingredient_id')->references('id')
                ->on('solo_ingredients')->onDelete('cascade');

            $table->increments('id');
            $table->string('quantity');
            $table->text('preparation');
            $table->text('measurement');
            $table->timestamps();
        });

        Schema::create('solo_recipe_steps', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('sortorder');
            $table->text('description');

            $table->integer('solo_recipe_id')->unsigned();
            $table->foreign('solo_recipe_id')->references('id')
                ->on('solo_recipes')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('solo_ingredient_solo_recipe');
        Schema::dropIfExists('solo_recipe_steps');
        Schema::dropIfExists('solo_ingredients');
        Schema::dropIfExists('solo_recipes');
    }
}
