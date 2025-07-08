<?php

namespace Sportmaster\Api\Laravel;

use Illuminate\Support\ServiceProvider;
use Sportmaster\Api\Client;
use Sportmaster\Api\Logger\FileLogger;
use Sportmaster\Api\TokenStorage\FileTokenStorage;

/**
 * Laravel service provider for the Sportmaster API client.
 */
class SportmasterApiServiceProvider extends ServiceProvider
{
    private $app;

    /**
     * Register services.
     * @throws \Exception
     */
    public function register(): void
    {
        $this->app->singleton(Client::class, function () {
            return new Client(
                null,
                new FileTokenStorage(storage_path('.sportmaster_token.json')),
                new FileLogger(storage_path('logs/sportmaster_api.log'))
            );
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}