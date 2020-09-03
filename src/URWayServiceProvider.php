<?php

namespace URWay;

use Illuminate\Support\ServiceProvider;

class URWayServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
    public function boot()
    {
        // Config file
        $this->publishes([
            __DIR__.'/../config/urway.php' => config_path('urway.php'),
        ]);

        // Merge config
        $this->mergeConfigFrom(__DIR__.'/../config/urway.php', 'urway');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Client::class, function () {
            return new Client();
        });
    }
}