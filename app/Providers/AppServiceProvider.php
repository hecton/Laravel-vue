<?php

namespace App\Providers;

use App\Repositories\Contracts\ClienteInterface;
use App\Repositories\Contracts\PedidoInterface;
use App\Repositories\Eloquent\ClienteRepository;
use App\Repositories\Eloquent\PedidoRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind( ClienteInterface::class, ClienteRepository::class );
        $this->app->bind( PedidoInterface::class, PedidoRepository::class );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
