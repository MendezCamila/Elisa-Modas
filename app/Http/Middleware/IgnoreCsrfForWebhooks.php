<?php

namespace App\Http\Middleware;

use Closure;

class IgnoreCsrfForWebhooks
{
    public function handle($request, Closure $next)
    {
        if ($request->is('webhook/mercadopago')) {
            return $next($request);
        }

        return csrf_token() ? $next($request) : abort(419);
    }
}
