<?php

namespace CG;

use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class CodeGeneratorServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/Resources/compile/' => public_path(''),
        ], 'public');
        $this->loadRoutesFrom(__DIR__ . '/routes.php');
        $this->loadViewsFrom(__DIR__ . '/Resources/views', 'CG');
        App::alias('Str', Str::class);
    }
}
