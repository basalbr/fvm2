<?php

namespace App\Providers;

use App\Models\AberturaEmpresa;
use Illuminate\Support\ServiceProvider;
use Observers\AberturaEmpresaObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        AberturaEmpresa::observe(AberturaEmpresaObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
