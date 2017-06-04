<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Mealplanmodel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solo_mealplans', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')
                ->on('users')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('solo_mealplan_solo_recipe', function (Blueprint $table) {
            $table->integer('solo_recipe_id')->unsigned()->nullable();
            $table->integer('solo_mealplan_id')->unsigned()->nullable();

            $table->foreign('solo_recipe_id')->references('id')
                ->on('solo_recipes')->onDelete('cascade');
            $table->foreign('solo_mealplan_id')->references('id')
                ->on('solo_mealplans')->onDelete('cascade');

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
        Schema::dropIfExists('solo_mealplan_solo_recipe');
        Schema::dropIfExists('solo_mealplans');
    }
}
