<?php

namespace App\Providers;

use App\Services\Payments\Factory\Stripe\StripeService;
use App\Services\Singletone\LoggerLaravel;
use Illuminate\Support\ServiceProvider;
use Stripe\StripeClient;

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
        $this->app->singleton(LoggerLaravel::class, function(){
            return new LoggerLaravel();
        });

        $this->app->when(StripeService::class)
            ->needs(StripeClient::class)
            ->give(function () {
                return new StripeClient(config('stripe.api_keys.secret_key'));
            });

    }
}
