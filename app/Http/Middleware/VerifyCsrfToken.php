<?php

namespace CodexShaper\App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VerifyCsrfToken
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
        $token = $request->input('_token') ?: $request->header('X-CSRF-TOKEN');
        $action = $request->wbp_nonce ?: 'wbp_nonce';

        if ( !wp_verify_nonce( $token, $action ) ) {
            if ($request->ajax()) {
                return wp_send_json(["message" => "CSRF Token mitchmatch"], 403 );
            }

            throw new \Exception("CSRF Token mismatch");
            
            
        }

        return $next($request);
    }
}
