<?php

namespace App\Providers;

use App\Integrations\KwickBox\KwickBox;
use Illuminate\Support\ServiceProvider;
use App\Shipping\Repositories\ShippingRepository;
use App\Shipping\Interfaces\ShippingRepositoryInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app->bind(ShippingRepositoryInterface::class, ShippingRepository::class);

        $this->app->bind(KwickBox::class, fn () => new KwickBox(
            config('services.kwickbox.api_key')
        ));
    }
}
