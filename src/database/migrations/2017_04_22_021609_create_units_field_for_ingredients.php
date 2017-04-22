<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUnitsFieldForIngredients extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solo_measurements', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('standard_amount');
            $table->timestamps();
        });

        Schema::create('solo_measurement_solo_ingredient', function (Blueprint $table) {
            $table->integer('solo_ingredient_id')->unsigned()->nullable();
            $table->integer('solo_measurement_id')->unsigned()->nullable();

            $table->foreign('solo_measurement_id')->references('id')
                ->on('solo_measurements')->onDelete('cascade');
            $table->foreign('solo_ingredient_id')->references('id')
                ->on('solo_ingredients')->onDelete('cascade');
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
        Schema::dropIfExists('solo_measurement_solo_ingredient');
        Schema::dropIfExists('solo_measurements');
    }
}
