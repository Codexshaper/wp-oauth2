<?php

namespace Codexshaper_Oauth_Server\App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use CodexShaper\Database\Facades\Schema;
use CodexShaper\OAuth2\Server\Http\Requests\ServerRequest;
use CodexShaper\OAuth2\Server\Manager;
use League\OAuth2\Server\Exception\OAuthServerException;
use Codexshaper_Oauth_Server\App\User;

/**
 * Auth middleware.
 *
 * @since      1.0.0
 * @package    Codexshaper_Oauth_Server
 * @subpackage Codexshaper_Oauth_Server/app/Http/Middleware
 * @author     Md Abu Ahsan basir <maab.career@gmail.com>
 */
class AuthMiddleware {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request $request The app request.
	 * @param  \Closure                 $next The next closure.
	 * @param  array                    $guards The request guards.
	 *
	 * @return mixed
	 */
	public function handle( Request $request, Closure $next, ...$guards ) {
		foreach ( $guards as $guard ) {
			if ( $guard == 'api' ) {
				if ( ! Schema::hasTable( 'oauth_access_tokens' ) ||
					! Schema::hasTable( 'oauth_refresh_tokens' ) ||
					! Schema::hasTable( 'oauth_personal_access_clients' ) ||
					! Schema::hasTable( 'oauth_clients' ) ||
					! Schema::hasTable( 'oauth_auth_codes' )
				) {
					throw new \Exception( 'Please install OAuth2 Server Plugin (plugin link) or Implement OAuth2 Server from this link (https://github.com/Codexshaper/oauth2)', 1 );
				}

				$manager         = new Manager();
				$resource_server = $manager->getResourceServer();
				$psr_request     = ServerRequest::getPsrServerRequest();

				try {
					$psr     = $resource_server->validateAuthenticatedRequest( $psr_request );
					$user_id = $manager->validateUserForRequest( $psr );

					if ( $user_id ) {
						$user = User::find( $user_id );

						$request->merge( array( 'user' => $user ) );
						$request->merge( array( 'scopes' => $psr->getAttribute( 'oauth_scopes' ) ) );

						$request->setUserResolver(
							function () use ( $user ) {
								return $user;
							}
						);

						return $next( $request );
					}
				} catch ( OAuthServerException $e ) {
					throw new \Exception( $e->getMessage() );

				}

				return $next( $request );
			}
		}

		if ( \is_user_logged_in() ) {
			return $next( $request );
		}

		header( 'Location: ' . \get_site_url() . '/wp-admin' );
		die();
	}
}
