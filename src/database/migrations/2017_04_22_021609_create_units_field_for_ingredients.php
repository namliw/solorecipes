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
        Schema::table('solo_measurements', function (Blueprint $table) {
            $table->string('name');
            $table->string('standard_amount');
            $table->timestamps();
        });

        Schema::table('solomeasurements_soloingredients', function (Blueprint $table) {
            $table->integer('soloingredient_id')->unsigned()->nullable();
            $table->integer('solomeasurement_id')->unsigned()->nullable();

            $table->foreign('solomeasurement_id')->references('id')
                ->on('solo_measurements')->onDelete('cascade');
            $table->foreign('soloingredient_id')->references('id')
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
        Schema::dropIfExists('solomeasurements_soloingredients');
        Schema::dropIfExists('solo_measurements');
    }
}
