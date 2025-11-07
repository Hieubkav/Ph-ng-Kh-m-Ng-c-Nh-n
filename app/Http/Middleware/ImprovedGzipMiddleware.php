<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ImprovedGzipMiddleware
{
    /**
     * URIs that should not be compressed
     */
    protected $excludedPaths = [
        'livewire/*',
        'admin/*',
        'api/*',
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Skip compression for excluded paths
        if ($this->shouldSkipCompression($request)) {
            return $response;
        }

        // Skip compression for non-GET requests (POST, PUT, DELETE etc.)
        if (!$request->isMethod('GET')) {
            return $response;
        }

        // Skip if it's an AJAX request from Livewire
        if ($request->header('X-Livewire')) {
            return $response;
        }

        // Skip if response is not HTML/Text/JSON
        $contentType = $response->headers->get('Content-Type', '');
        if (!$this->isCompressibleContentType($contentType)) {
            return $response;
        }

        // Only compress if client accepts gzip and response is not already compressed
        if ($request->header('Accept-Encoding') && 
            strpos($request->header('Accept-Encoding'), 'gzip') !== false &&
            !$response->headers->has('Content-Encoding')) {

            // Get response content
            $content = $response->getContent();

            // Only compress if content is larger than 1KB and not empty
            if (!empty($content) && strlen($content) > 1024) {
                $compressed = gzencode($content, 6); // Use level 6 instead of 9 for better performance

                if ($compressed !== false) {
                    $response->setContent($compressed);
                    $response->headers->set('Content-Encoding', 'gzip');
                    $response->headers->set('Content-Length', strlen($compressed));
                    $response->headers->set('Vary', 'Accept-Encoding');
                }
            }
        }

        return $response;
    }

    /**
     * Check if request should skip compression
     */
    protected function shouldSkipCompression(Request $request): bool
    {
        foreach ($this->excludedPaths as $path) {
            if ($request->is($path)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if content type is compressible
     */
    protected function isCompressibleContentType(string $contentType): bool
    {
        $compressibleTypes = [
            'text/html',
            'text/plain',
            'text/css',
            'text/javascript',
            'application/javascript',
            'application/json',
            'application/xml',
            'text/xml',
        ];

        foreach ($compressibleTypes as $type) {
            if (strpos($contentType, $type) !== false) {
                return true;
            }
        }

        return false;
    }
}
