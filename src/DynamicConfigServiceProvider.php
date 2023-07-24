<?php

namespace zukyDev\DynamicConfig;

use Illuminate\Support\ServiceProvider;
use zukyDev\DynamicConfig\Console\Commands\DynamicConfigDestroyCommand;
use zukyDev\DynamicConfig\Console\Commands\DynamicConfigStoreCommand;
use zukyDev\DynamicConfig\Console\Commands\DynamicConfigUpdateCommand;
use zukyDev\DynamicConfig\Services\DynamicConfigService;

class DynamicConfigServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        app()->singleton(DynamicConfigService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        resolve(DynamicConfigService::class);

        $this->publish();
        $this->loadCommands();
    }

    private function publish(): void
    {
        if (app()->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/database/migrations/' => database_path('migrations/dynamic-config'),
            ], 'dynamic-config-migrations');
        }
    }

    private function loadCommands(): void
    {
        if (app()->runningInConsole()) {
            $this->commands([
                DynamicConfigStoreCommand::class,
                DynamicConfigUpdateCommand::class,
                DynamicConfigDestroyCommand::class
            ]);
        }
    }

}
