<?php

namespace CodexShaper\OAuth2\Server;

use CodexShaper\OAuth2\Server\Repositories\AccessTokenRepository;
use CodexShaper\OAuth2\Server\Repositories\AuthCodeRepository;
use CodexShaper\OAuth2\Server\Repositories\ClientRepository;
use CodexShaper\OAuth2\Server\Repositories\RefreshTokenRepository;
use CodexShaper\OAuth2\Server\Repositories\ScopeRepository;
use CodexShaper\OAuth2\Server\Repositories\UserRepository;
use DateInterval;
use Defuse\Crypto\Key;
use League\OAuth2\Server\AuthorizationServer;
use League\OAuth2\Server\CryptKey;
use League\OAuth2\Server\Grant\AuthCodeGrant;
use League\OAuth2\Server\Grant\ClientCredentialsGrant;
use League\OAuth2\Server\Grant\ImplicitGrant;
use League\OAuth2\Server\Grant\PasswordGrant;
use League\OAuth2\Server\Grant\RefreshTokenGrant;
use League\OAuth2\Server\ResourceServer;
use phpseclib\Crypt\RSA;

class Manager
{
    /**
     * Authorization server.
     *
     * @var string
     */
    protected $server;

    /**
     * All scopes.
     *
     * @var string
     */
    protected static $scopes = [
        'read'       => 'Read',
        'read_write' => 'Read and Write',
    ];

    /**
     * Default scope.
     *
     * @var string
     */
    protected static $defaultScope;

    /**
     * Enable or didable implicit grant.
     *
     * @var string
     */
    protected $isEnableImplicitGrant = false;

    /**
     * Refresh token expire at.
     *
     * @var string
     */
    protected static $refreshTokensExpireAt = 'P1Y';

    /**
     * token exipre at.
     *
     * @var string
     */
    protected static $tokensExpireAt = 'P1Y';

    /**
     * Create RSA authorisation keys.
     *
     * @return void
     */
    public static function keys($dir = null)
    {
        if (!$dir) {
            $dir = __DIR__.'/../storage/rsa';
        }

        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        $publicKey = $dir.'/oauth-public.key';
        $privateKey = $dir.'/oauth-private.key';
        $rsa = new RSA();
        $keys = $rsa->createKey(4096);

        file_put_contents($publicKey, $keys['publickey']);
        file_put_contents($privateKey, $keys['privatekey']);
    }

    /**
     * Add New scopes.
     *
     * @return void
     */
    public static function setScopes(array $scopes = [])
    {
        if (!empty($scopes)) {
            return;
        }

        static::$scopes = array_merge(static::$scopes, $scopes);
    }

    /**
     * Get all available scopes.
     *
     * @return array
     */
    public static function getScopes()
    {
        return static::$scopes;
    }

    /**
     * Given a client, grant type and optional user identifier validate the set of scopes requested are valid and optionally
     * append additional scopes or remove requested scopes.
     *
     * @param \League\OAuth2\Server\Entities\ScopeEntityInterface[] $scopes
     * @param string                                                $grantType
     * @param \League\OAuth2\Server\Entities\ClientEntityInterface  $clientEntity
     * @param null|string                                           $userIdentifier
     *
     * @return \League\OAuth2\Server\Entities\ScopeEntityInterface[]
     */
    public static function filterScopes($scopes, $grantType)
    {
        if (!in_array($grantType, ['password', 'personal_access', 'client_credentials'])) {
            $scopes = array_filter($scopes, function ($scope) {
                return trim($scope->getIdentifier()) !== '*';
            });
        }

        return array_filter($scopes, function ($scope) {
            return static::hasScope($scope->getIdentifier());
        });
    }

    /**
     * Create a CryptKey instance without permissions check.
     *
     * @param string $identifier
     *
     * @return bool
     */
    public static function hasScope($identifier)
    {
        return trim($identifier) === '*' || array_key_exists($identifier, static::$scopes);
    }

    /**
     * Check is isset a scope or not.
     *
     * @param string $identifier
     *
     * @return bool
     */
    public static function isValidateScope($identifier)
    {
        return array_key_exists($identifier, static::$scopes);
    }

    /**
     * Make the authorization service instance.
     *
     * @return \League\OAuth2\Server\AuthorizationServer
     */
    public function makeAuthorizationServer()
    {
        $encryptionKey = 'def00000069ceedc03a1f91fd51a49ce08ebb8580d688f4fbc3774c86aaa4df516eea0f72c1f62e3e577ec9f0c83c773b890222966bf93ac22e84a9eca55638be310665b';

        $this->server = new AuthorizationServer(
            new ClientRepository(),
            new AccessTokenRepository(),
            new ScopeRepository(),
            $this->makeCryptKey('private'),
            Key::loadFromAsciiSafeString($encryptionKey)
        );

        $this->server->setDefaultScope(static::$defaultScope);
        $this->enableGrantTypes();

        return $this->server;
    }

    /**
     * Enable All grant types.
     *
     * @return void
     */
    protected function enableGrantTypes()
    {
        $this->server->enableGrantType(
            new ClientCredentialsGrant(),
            new DateInterval(static::$tokensExpireAt) // access tokens will expire after 1 hour
        );

        $this->enableAuthCodeGrant();
        $this->enablePasswordGrant();
        $this->enableRefreshTokenGrant();

        if ($this->isEnableImplicitGrant) {
            $this->server->enableGrantType(
                new ImplicitGrant(new DateInterval(static::$tokensExpireAt)),
                new DateInterval(static::$tokensExpireAt) // access tokens will expire after 1 hour
            );
        }
    }

    /**
     * Enable Authorization code Grant.
     *
     * @return void
     */
    protected function enableAuthCodeGrant()
    {
        $authCodeGrant = new AuthCodeGrant(
            new AuthCodeRepository(),
            new RefreshTokenRepository(),
            new DateInterval('PT10M')
        );

        $authCodeGrant->setRefreshTokenTTL(new DateInterval(static::$refreshTokensExpireAt));

        $this->server->enableGrantType(
            $authCodeGrant,
            new DateInterval(static::$tokensExpireAt)
        );
    }

    /**
     * Enable Password Grant.
     *
     * @return void
     */
    protected function enablePasswordGrant()
    {
        $passwordGrant = new PasswordGrant(
            new UserRepository(),
            new RefreshTokenRepository()
        );

        $passwordGrant->setRefreshTokenTTL(new DateInterval(static::$refreshTokensExpireAt)); // refresh tokens will expire after 1 month

        // Enable the password grant on the server
        $this->server->enableGrantType(
            $passwordGrant,
            new DateInterval(static::$tokensExpireAt) // access tokens will expire after 1 hour
        );
    }

    /**
     * Enable Refresh token Grant.
     *
     * @return void
     */
    protected function enableRefreshTokenGrant()
    {
        $refreshTokenGrant = new RefreshTokenGrant(new RefreshTokenRepository());
        $refreshTokenGrant->setRefreshTokenTTL(new \DateInterval(static::$refreshTokensExpireAt)); // new refresh tokens will expire after 1 month

        // Enable the refresh token grant on the server
        $this->server->enableGrantType(
            $refreshTokenGrant,
            new \DateInterval(static::$tokensExpireAt) // new access tokens will expire after an hour
        );
    }

    /**
     * Create a resource server for validation.
     *
     * @return \League\OAuth2\Server\ResourServer
     */
    public function getResourceServer()
    {
        return new ResourceServer(
            new AccessTokenRepository(),
            $this->makeCryptKey('public')
        );
    }

    /**
     * Create a CryptKey instance without permissions check.
     *
     * @param string $key
     *
     * @return \League\OAuth2\Server\CryptKey
     */
    protected function makeCryptKey($type)
    {
        $key = __DIR__.'/../storage/rsa/oauth-'.$type.'.key';

        return new CryptKey($key, null, false);
    }

    public function validateUserForRequest($request)
    {
        $token = Model::instance('tokenModel')->find($request->getAttribute('oauth_access_token_id'));
        $client = Model::instance('clientModel')->find($request->getAttribute('oauth_client_id'));

        if (!$token || !$client) {
            return null;
        }

        if (!$token->user_id && !$client->user_id) {
            return null;
        }

        if ($token->user_id != null) {
            return $token->user_id;
        }

        return $client->user_id;
    }

    /**
     * Load all routes.
     *
     * @return void
     */
    public static function routes()
    {
        require __DIR__.'/../routes/oauth.php';
    }

    /**
     * Migrate tables.
     *
     * @param string $dir
     *
     * @return void
     */
    public static function migrate($dir = null)
    {
        if (is_null($dir)) {
            $dir = __DIR__.'/../database/migrations';
        }

        foreach (glob($dir.'/*.php') as $file) {
            require_once $file;
            $table = pathinfo($file)['filename'];
            (new $table())->up();
        }
    }

    /**
     * Drop tables.
     *
     * @param string $dir
     *
     * @return void
     */
    public static function rollback($dir = null)
    {
        if (is_null($dir)) {
            $dir = __DIR__.'/../database/migrations';
        }

        foreach (glob($dir.'/*.php') as $file) {
            require_once $file;
            $table = pathinfo($file)['filename'];
            (new $table())->down();
        }
    }

    /**
     * Drop and migrate fresh tables.
     *
     * @param string $dir
     *
     * @return void
     */
    public static function refresh($dir = null)
    {
        if (is_null($dir)) {
            $dir = __DIR__.'/../database/migrations';
        }

        static::rollback($dir);
        static::migrate($dir);
    }
}
