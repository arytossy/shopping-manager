<?php

namespace App\Providers;

use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (! \App::environment('local')) {
            \URL::forceScheme('https');
        }

        /**
         * APIリソースを'data'でラップしない
         */
        Resource::withoutWrapping();
    }
}
