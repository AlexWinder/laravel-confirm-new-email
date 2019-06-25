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
        // Publish config file
        $this->publishes([
            __DIR__ . '/config/config.php' => config_path('confirm-new-email.php'),
        ]);

        // Register routes
        $this->loadRoutesFrom(__DIR__ . '/routes.php');
    }
}
