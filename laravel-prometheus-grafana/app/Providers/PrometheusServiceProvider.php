<?php

namespace App\Providers;

use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;
use Prometheus\CollectorRegistry;
use Prometheus\Exception\MetricsRegistrationException;
use Prometheus\Storage\Redis;

class PrometheusServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton( CollectorRegistry::class, function () {

            Redis::setDefaultOptions(
                Arr::only( config( 'database.redis.default' ), [ 'host', 'password', 'username' ] )
            );

            return CollectorRegistry::getDefault();

        } );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
//        // Register HTTP status code gauge
//        $httpStatusGauge = $registry->getOrRegisterGauge(
//            'app',
//            'http_status_code',
//            'HTTP response codes',
//            ['status_code']
//        );
//
//        // Register latency histogram
//        $latencyHistogram = $registry->getOrRegisterHistogram(
//            'app',
//            'request_latency_seconds',
//            'Latency of HTTP requests in seconds',
//            ['method', 'route']
//        );
//
//        // Register FPM workers gauge
//        $fpmGauge = $registry->getOrRegisterGauge(
//            'app',
//            'fpm_worker_count',
//            'Number of active FPM workers'
//        );
//
//        // Register CPU usage gauge
//        $cpuGauge = $registry->getOrRegisterGauge(
//            'app',
//            'cpu_usage',
//            'CPU usage percentage'
//        );
//
//        // Example: measure latency (assumes you're using middleware for request timing)
//        $this->app['events']->listen('kernel.handled', function ($request) use ($latencyHistogram) {
//            $start = LARAVEL_START;
//            $duration = microtime(true) - $start;
//            $latencyHistogram->observe($duration, [$request->method(), $request->path()]);
//        });
    }
}
