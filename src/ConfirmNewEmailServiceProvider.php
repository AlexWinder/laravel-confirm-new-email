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
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
       $this->loadRoutesFrom(__DIR__ . '/routes.php');
    }
}
