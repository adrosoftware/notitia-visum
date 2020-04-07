<?php

namespace NotitiaVisum\Provider;

use Illuminate\Support\ServiceProvider;

class NotitiaVisumServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            realpath(dirname(dirname(__DIR__))) . '/config/notitia-visum.php',
            'notitia-visum'
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(
            realpath(dirname(dirname(__DIR__))) . '/resources/views',
            'notitia-visum'
        );
        $this->publishes([
            realpath(dirname(dirname(__DIR__))) . '/config/notitia-visum.php' => config_path('notitia-visum.php'),
            realpath(dirname(dirname(__DIR__))) . '/resources/views' => resource_path('views/vendor/notitia-visum'),
        ]);


    }
}
