<?php

namespace WPB\App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use CodexShaper\Database\Facades\Schema;
use CodexShaper\OAuth2\Server\Http\Requests\ServerRequest;
use CodexShaper\OAuth2\Server\Manager;
use League\OAuth2\Server\Exception\OAuthServerException;
use WPB\App\User;

/**
 * Scope middleware.
 *
 * @since      1.0.0
 * @package    Codexshaper_Oauth_Server
 * @subpackage Codexshaper_Oauth_Server/app/Http/Middleware
 * @author     Md Abu Ahsan basir <maab.career@gmail.com>
 */
class Scope {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request $request The app request.
	 * @param  \Closure                 $next The next closure.
	 * @param  array                    $scopes Requested scopes.
	 * @return mixed
	 */
	public function handle( Request $request, Closure $next, ...$scopes ) {
		foreach ( $scopes as $scope ) {
			if ( ! in_array( $scope, $request->scopes ) ) {
				wp_send_json( array( 'msg' => "You don't have enough permission" ), 400 );
			}
		}

		return $next( $request );
	}
}
