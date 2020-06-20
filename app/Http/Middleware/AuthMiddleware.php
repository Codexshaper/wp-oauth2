<?php

namespace CodexShaper\App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(\is_user_logged_in()) {
            return $next($request);
        }
        
        header('Location: '.\get_site_url().'/wp-admin');
        die();
    }
}
