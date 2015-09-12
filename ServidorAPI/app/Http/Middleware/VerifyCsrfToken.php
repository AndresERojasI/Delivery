<?php

namespace Shipper\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;
use Closure;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        //
    ];

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $uri_segments = $request->segments();
        $subdominio = $request->root();
        $subdominio = str_replace('http://', '', $subdominio);
        $subdominio = explode('.', $subdominio);
        $subdominio = $subdominio['0'];

        if ($subdominio === 'api') {
            return $next($request);
        }

        return parent::handle($request, $next);
    }
}
