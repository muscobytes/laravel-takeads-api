<?php

namespace Muscobytes\Laravel\TakeadsApi;

use Illuminate\Support\ServiceProvider;
use Muscobytes\Laravel\TakeadsApi\Settings\ConfigSettings;
use Muscobytes\TakeadsApi\Client;

class TakeadsApiServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(TakeadsApi::class, function ($app) {
            return new TakeadsApi(
                new (config('takeads.settings_provider', ConfigSettings::class))(),
                new Client()
            );
        });
    }


    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../config/takeads.php' => config_path('takeads.php'),
        ], 'config');
    }
}
