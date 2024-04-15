<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    public function handle($request, \Closure $next)
    {
        if(env('APP_ENV') !== 'testing')
        {
            return parent::handle($request, $next);
        }

        return $next($request);
    }
    
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        //
    ];
}
