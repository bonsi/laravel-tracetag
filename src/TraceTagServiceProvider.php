<?php declare(strict_types=1);

namespace Bonsi\TraceTag;

use Illuminate\Container\Container;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Http\Kernel;
use \Illuminate\Support\ServiceProvider;
use Bonsi\TraceTag\Generators\Uuid4Generator;
use Bonsi\TraceTag\Generators\RandomIntGenerator;
use Bonsi\TraceTag\Middleware\TraceTagMiddleware;

/**
 * Class TraceTagServiceProvider
 *
 * @package Bonsi\TraceTag
 */
class TraceTagServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $source = realpath(__DIR__ . '/../config/trace-tag.php');
        $this->publishes([$source => config_path('trace-tag.php')]);
        $this->mergeConfigFrom($source, 'trace-tag');

        if($this->app->config->get('trace-tag.middleware.enabled', false))
        {
            $this->registerMiddleware(TraceTagMiddleware::class);
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        Log::getMonolog()->pushProcessor(new \Bonsi\TraceTag\Integrations\MonologProcessor);

        $this->app->singleton('tracetag', function(Container $app) {
            $generatorClass = $app->config->get('tracetag.generator', RandomIntGenerator::class);
            return new TraceTag(new $generatorClass);
        });

        $this->app->alias('tracetag', TraceTag::class);
    }

    /**
     * Register the TraceTag middleware.
     *
     * @param $middleware
     */
    public function registerMiddleware( $middleware )
    {
        $kernel = $this->app[Kernel::class];

//        $kernel->prependMiddleware($middleware);
        $kernel->pushMiddleware($middleware);
    }

}
