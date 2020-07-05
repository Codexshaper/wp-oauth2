<?php

namespace Codexshaper_Oauth_Server\App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

/**
 * Scope middleware.
 *
 * @since      1.0.0
 * @package    Codexshaper_Oauth_Server
 * @subpackage Codexshaper_Oauth_Server/app/Http/Middleware
 * @author     Md Abu Ahsan basir <maab.career@gmail.com>
 */
class VerifyCsrfToken {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request $request The app request.
	 * @param  \Closure                 $next The next closure.
	 *
	 * @throws \Exception Throw an error when mismatch nonce.
	 *
	 * @return mixed
	 */
	public function handle( Request $request, Closure $next ) {
		$token  = $request->input( '_token' ) ?? $request->header( 'X-CSRF-TOKEN' );
		$action = $request->codexshaper_oauth_server_nonce ?? 'codexshaper_oauth_server_nonce';

		if ( ! wp_verify_nonce( $token, $action ) ) {
			if ( $request->ajax() ) {
				return wp_send_json( array( 'message' => 'CSRF Token mitchmatch' ), 403 );
			}

			throw new \Exception( 'CSRF Token mismatch' );

		}

		return $next( $request );
	}
}
