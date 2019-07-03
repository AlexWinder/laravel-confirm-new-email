<?php

namespace AlexWinder\ConfirmNewEmail;

use Illuminate\Support\ServiceProvider;

class ConfirmNewEmailServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // Merge config file
        $this->mergeConfigFrom(
            __DIR__ . '/config/config.php', 'confirm-new-email'
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Publish view files
        $this->publishes([
            __DIR__.'/views' => resource_path('views/vendor/confirm-new-email'),
        ], 'views');
        
        // Publish config file
        $this->publishes([
            __DIR__ . '/config/config.php' => config_path('confirm-new-email.php'),
        ], 'config');

        // Register views
        $this->loadViewsFrom(__DIR__.'/views', 'confirm-new-email');

        // Register routes
        $this->loadRoutesFrom(__DIR__ . '/routes.php');
    }
}
