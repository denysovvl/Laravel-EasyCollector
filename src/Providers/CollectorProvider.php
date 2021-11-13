<?php

namespace Denysovvl\EasyCollector\Providers;

use Illuminate\Support\ServiceProvider;
use Denysovvl\EasyCollector\Commands\CreateCollectorCommand;

class CollectorProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                CreateCollectorCommand::class,
            ]);
        }
    }
}
