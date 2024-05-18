<?php

namespace Bunitech\DrawErd;

use Illuminate\Support\ServiceProvider;

class DrawErdServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes.php');

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'draw-erd');

        $this->publishes([
            __DIR__.'/../config/draw-erd.php' => config_path('draw-erd.php'),
        ]);
		
        $this->publishes([
			dirname(__DIR__) . '/public' => public_path('vendor/draw-erd'),
        ], 'draw-erd');
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/draw-erd.php', 'draw-erd');
    }
}
