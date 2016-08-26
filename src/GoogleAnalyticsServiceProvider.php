<?php

namespace Galahad\LaravelAnalyticsSync;

use Illuminate\Support\ServiceProvider;

class GoogleAnalyticsServiceProvider extends ServiceProvider
{
    /**
     * Register method
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(MigrationCommand::class, function($app) {
            return new MigrationCommand();
        });
    }

    /**
     * Boot method
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/analytics.php' => config_path('analytics.php'),
        ]);

        $this->commands(MigrationCommand::class);
    }
}