<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Schema;
class AppServiceProvider extends ServiceProvider
{
    /**
     *  
     */
    public function register(): void
    {
        //
    }

    /**
     *  
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);
    }
}
