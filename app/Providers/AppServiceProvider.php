<?php

namespace App\Providers;

use App\Models\AberturaEmpresa;
use App\Models\Mensagem;
use Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Observers\MensagemObserver;
use PagSeguro\Configuration\Configure;
use PagSeguro\Library;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Mensagem::observe(MensagemObserver::class);
        Schema::defaultStringLength(191);
        /**
         * Publica bootstrap da pasta vendor para public
         */
        $this->publishes([
            __DIR__ . '/../../vendor/twbs/bootstrap/dist' => public_path('/vendor'),
        ], 'public');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

        Library::initialize();
        Configure::setAccountCredentials(env('PAGSEGURO_EMAIL') ?: '', env('PAGSEGURO_TOKEN_PRODUCTION') ?: '');
        Configure::setCharset('UTF-8');
        if ($this->app->environment() !== 'production') {
            $this->app->register(IdeHelperServiceProvider::class);
            $this->app->bind('path.public', function () {
                return '/public/';
            });
        } else {
            $this->app->bind('path.public', function () {
                return '/';
            });
        }
        App::make('files')->link(storage_path('app/public'), public_path('storage'));
    }
}
