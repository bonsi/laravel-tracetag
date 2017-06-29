<?php

namespace Bonsi\TraceTag;

use Bonsi\TraceTag\Generators\Uuid4;
use Bonsi\TraceTag\Generators\RandomInt;
use \Illuminate\Support\ServiceProvider;

class TraceTagServiceProvider extends ServiceProvider
{
//    protected $defer = true;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(TraceTag::class, function($app) {
            return new TraceTag(new RandomInt);
//            return new TraceTag(new Uuid4);
        });
    }
}
