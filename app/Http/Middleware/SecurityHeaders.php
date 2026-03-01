<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;

/**
 * SecurityHeaders Middleware
 *
 * Adds essential security HTTP headers to all responses
 * to protect against common web vulnerabilities such as
 * XSS, clickjacking, MIME-type sniffing, and more.
 *
 * @author Mohammed Belmekki
 */
class SecurityHeaders
{
    /**
     * Security headers to be applied to every response.
     *
     * @var array
     */
    protected $headers = [
        'X-Content-Type-Options'  => 'nosniff',
        'X-Frame-Options'         => 'SAMEORIGIN',
        'X-XSS-Protection'        => '1; mode=block',
        'Referrer-Policy'          => 'strict-origin-when-cross-origin',
        'Permissions-Policy'       => 'camera=(), microphone=(), geolocation=()',
    ];

    /**
     * Handle an incoming request.
     *
     * Attaches security headers to the outgoing response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        foreach ($this->headers as $key => $value) {
            $response->headers->set($key, $value);
        }

        // Remove server version header to prevent information disclosure
        $response->headers->remove('X-Powered-By');
        $response->headers->remove('Server');

        return $response;
    }
}
