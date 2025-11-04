<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class GzipMiddleware
{
    /**
    * Handle an incoming request.
    *
    * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
    */
    public function handle(Request $request, Closure $next): Response
    {
    $response = $next($request);

        // Only compress if client accepts gzip and response is not already compressed
        if ($request->header('Accept-Encoding') && strpos($request->header('Accept-Encoding'), 'gzip') !== false &&
            !$response->headers->has('Content-Encoding')) {

            // Get response content
            $content = $response->getContent();

            // Only compress if content is not empty and not already compressed
            if (!empty($content)) {
                $compressed = gzencode($content, 9);

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
}
