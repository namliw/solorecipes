<?php

/**
 * Created by PhpStorm.
 * User: wcorc
 * Date: 17/04/2017
 * Time: 7:21 PM
 */
use Illuminate\Database\Seeder;
class SolorecipesSeeder extends Seeder
{

    public function run()
    {
        factory(\Solocode\Solorecipes\Model\SoloIngredient::class,100)->create();
        factory(\Solocode\Solorecipes\Model\SoloRecipe::class, 50)->create()->each(function ($u) {
            $u->steps()->save(factory(\Solocode\Solorecipes\Model\SoloRecipeStep::class)->make());
            $u->steps()->save(factory(\Solocode\Solorecipes\Model\SoloRecipeStep::class)->make());
            $u->steps()->save(factory(\Solocode\Solorecipes\Model\SoloRecipeStep::class)->make());
            $ing = [];
            $ing[] = rand(1,100);
            $ing[] = rand(1,100);
            $ing[] = rand(1,100);
            $u->ingredients()->attach($ing,['quantity' => 1,'preparation' => 'sliced']);
        });
    }

}