<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Explicitly ALLOW the sensors that scripts are trying to use
        // This stops the browser "Violation" warnings.
        $permissionsPolicy = 'accelerometer=(self), ambient-light-sensor=(), autoplay=(), battery=(), camera=(), display-capture=(), document-domain=(), encrypted-media=(), fullscreen=(), geolocation=(self), gyroscope=(self), layout-animations=(), legacy-image-formats=(), magnetometer=(self), microphone=(), midi=(), payment=(), picture-in-picture=(), publickey-credentials-get=(), screen-wake-lock=(), speaker-selection=(), sync-xhr=(), usb=(), xr-spatial-tracking=()';
        
        $response->headers->set('Permissions-Policy', $permissionsPolicy);
        
        // Legacy Feature-Policy for older browsers
        $featurePolicy = "accelerometer 'self'; geolocation 'self'; gyroscope 'self'; magnetometer 'self'";
        $response->headers->set('Feature-Policy', $featurePolicy);

        // Security headers
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        
        // CORS: Handle unsafe headers that scripts are trying to read
        // The header "x-rtb-fingerprint-id" is commonly used by ad-tech and tracking scripts
        $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, X-XSRF-TOKEN, X-CSRF-TOKEN, Authorization, X-Requested-With, x-rtb-fingerprint-id');
        $response->headers->set('Access-Control-Expose-Headers', 'x-rtb-fingerprint-id');
        $response->headers->set('Access-Control-Allow-Origin', $request->headers->get('Origin') ?? '*');
        $response->headers->set('Access-Control-Allow-Credentials', 'true');

        return $response;
    }
}
