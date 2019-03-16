<?php

namespace Gajo\Providers;

use Illuminate\Support\ServiceProvider;

class HelperFunctions extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot() { }

    /**
     * Register services.
     *
     * @return void
     */
    public function register() {
        require_once app_path('Helper/HelperFunctions.php');
    }
}
