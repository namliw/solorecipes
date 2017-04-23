<?php

namespace Solocode\Solorecipes;

use Illuminate\Support\ServiceProvider;

class SolorecipesServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        \Blade::setEchoFormat('nl2br(e(%s))');
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
        $this->loadViewsFrom(__DIR__ . '/views', 'solorecipes');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        include __DIR__ . '/routes.php';
        $this->app->make('Solocode\Solorecipes\Controllers\SolorecipesController');
        $this->app->make('Solocode\Solorecipes\Controllers\SoloingredientsController');
        $this->publishes([
            __DIR__ . '/views' => base_path('resources/views/vendor/solocode/solorecipes'),
        ]);
        $this->publishes([
            __DIR__ . '/assets' => base_path('public/solocode'),
        ]);
        $this->publishes([
            __DIR__ . '/database/seeds' => base_path('database/seeds'),
        ]);
    }
}
