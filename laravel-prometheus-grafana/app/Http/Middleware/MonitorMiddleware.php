<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Prometheus\CollectorRegistry;
use Prometheus\Exception\MetricsRegistrationException;
use Symfony\Component\HttpFoundation\Response;

class MonitorMiddleware
{
    private CollectorRegistry $collectorRegistry;

    public function __construct(CollectorRegistry $registry)
    {
        $this->collectorRegistry = $registry;
    }

    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     * @throws MetricsRegistrationException
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Start timing the request
        $startTime = microtime(true);

        // Proceed with the request
        $response = $next($request);

        // Calculate latency
        $latency = microtime(true) - $startTime;

        // Record HTTP status code
        $statusGauge = $this->collectorRegistry->getOrRegisterCounter(
            'app',
            'http_status_code',
            'HTTP response codes',
            ['status_code']
        );
        $statusGauge->inc([$response->getStatusCode()]);

        // Record latency
        $latencyHistogram = $this->collectorRegistry->getOrRegisterHistogram(
            'app',
            'request_latency_seconds',
            'Request latency',
            ['method', 'route']
        );
        $latencyHistogram->observe($latency, [$request->method(), $request->path()]);

        return $response;
    }
}
