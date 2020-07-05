<?php

namespace CodexShaper\OAuth2\Server;

use Carbon\Carbon;
use CodexShaper\OAuth2\Server\Entities\Client as ClientEntity;
use CodexShaper\OAuth2\Server\Manager;
use DateTime;

class Model
{
    /**
     * @var string
     */
    protected static $authCodeModel = '\CodexShaper\OAuth2\Server\Models\AuthCode';

    /**
     * @var string
     */
    protected static $clientModel = '\CodexShaper\OAuth2\Server\Models\Client';

    /**
     * @var string
     */
    protected static $refreshTokenModel = '\CodexShaper\OAuth2\Server\Models\RefreshToken';

    /**
     * @var string
     */
    protected static $tokenModel = '\CodexShaper\OAuth2\Server\Models\Token';

    /**
     * @var string
     */
    protected static $userModel = '\CodexShaper\OAuth2\Server\Models\User';

    /**
     * Create a new model instance.
     *
     * @param string $model The model name
     *
     * @return \CodexShaper\OAuth2\Server\Models\AuthCode|\CodexShaper\OAuth2\Server\Models\Client|\CodexShaper\OAuth2\Server\Models\RefreshToken|\CodexShaper\OAuth2\Server\Models\Token|\CodexShaper\OAuth2\Server\Models\User|null
     */
    public static function instance($model)
    {
        if (!static::${$model}) {
            return null;
        }

        return new static::${$model}();
    }

    /**
     * Get a client.
     *
     * @param string $clientIdentifier The client's identifier
     *
     * @return \League\OAuth2\Server\Entities\ClientEntityInterface|null
     */
    public static function getClientEntity($clientIdentifier)
    {
        $client = static::instance('clientModel');

        $record = $client->where($client->getKeyName(), $clientIdentifier)->first();

        if (!$record) {
            return;
        }

        return new ClientEntity(
            $clientIdentifier,
            $record->name,
            $record->redirect,
            $record->isConfidential()
        );
    }

    /**
     * store a new auth code to permanent storage.
     *
     * @param \League\OAuth2\Server\Entities\AuthCodeEntityInterface $accessTokenEntity
     *
     * @return void
     */
    public static function storeAuthCode($authCodeEntity)
    {
        static::instance('authCodeModel')->create([
            'id'         => $authCodeEntity->getIdentifier(),
            'user_id'    => $authCodeEntity->getUserIdentifier(),
            'client_id'  => $authCodeEntity->getClient()->getIdentifier(),
            'scopes'     => $authCodeEntity->getScopes(),
            'revoked'    => 0,
            'expires_at' => $authCodeEntity->getExpiryDateTime(),
        ]);
    }

    /**
     * store a new access token to permanent storage.
     *
     * @param \League\OAuth2\Server\Entities\AccessTokenEntityInterface $accessTokenEntity
     *
     * @return void
     */
    public static function storeAccessToken($accessTokenEntity)
    {
        static::instance('tokenModel')->create([
            'id'         => $accessTokenEntity->getIdentifier(),
            'user_id'    => $accessTokenEntity->getUserIdentifier(),
            'client_id'  => $accessTokenEntity->getClient()->getIdentifier(),
            'scopes'     => $accessTokenEntity->getScopes(),
            'revoked'    => false,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
            'expires_at' => $accessTokenEntity->getExpiryDateTime(),
        ]);
    }

    /**
     * store a new access refresh token to permanent storage.
     *
     * @param \League\OAuth2\Server\Entities\RefreshTokenEntityInterface $refreshTokenEntity
     *
     * @return void
     */
    public static function storeRefreshToken($refreshTokenEntity)
    {
        static::instance('refreshTokenModel')->create([
            'id'              => $refreshTokenEntity->getIdentifier(),
            'access_token_id' => $refreshTokenEntity->getAccessToken()->getIdentifier(),
            'revoked'         => false,
            'expires_at'      => $refreshTokenEntity->getExpiryDateTime(),
        ]);
    }

    /**
     * Validate a client's secret.
     *
     * @param string      $clientIdentifier The client's identifier
     * @param null|string $clientSecret     The client's secret (if sent)
     * @param null|string $grantType        The type of grant the client is using (if sent)
     *
     * @return bool
     */
    public static function validateClientCredentials($clientIdentifier, $clientSecret, $grantType)
    {
        $client = static::instance('clientModel');

        $record = $client->where($client->getKeyName(), $clientIdentifier)->first();

        if (!$record || !static::handlesGrant($record, $grantType)) {
            return false;
        }

        $scopes = is_array($record->scopes) ? $record->scopes : [];
        Manager::setScopes($scopes);

        return !$record->isConfidential() || hash_equals($record->secret, (string) $clientSecret);
    }

    /**
     * Determine if the given client can handle the given grant type.
     *
     * @param \CodexShaper\OAuth2\Server\Models\Client $record
     * @param string                                   $grantType
     *
     * @return bool
     */
    protected static function handlesGrant($record, $grantType)
    {
        if (is_array($record->grant_types) && !in_array($grantType, $record->grant_types)) {
            return false;
        }

        switch ($grantType) {
            case 'authorization_code':
                return $record->authorization_code_client;
            case 'password':
                return $record->password_client;
            case 'client_credentials':
                return $record->isConfidential();
            default:
                return true;
        }
    }

    /**
     * Veryfy user credentials for current grant.
     *
     * @param string                                               $username
     * @param string                                               $password
     * @param string                                               $grantType
     * @param \League\OAuth2\Server\Entities\ClientEntityInterface $clientEntity
     *
     * @return \CodexShaper\OAuth2\Server\Models\User|null
     */
    public static function verifyUserForGrant($username, $password, $grantType, $clientEntity)
    {
        if ($grantType == 'password') {
            $user = static::instance('userModel')->where('user_email', $username)->first();

            if (!$user) {
                return null;
            }

            if (!md5($password) === $user->password) {
                return null;
            }

            return $user->{$user->getKeyName()};
        }

        return null;
    }

    /**
     * Revoke provided token id.
     *
     * @param string $model
     * @param string $grantType
     *
     * @return void
     */
    public static function revoke($model, $tokenId)
    {
        static::instance($model)->whereId($tokenId)->update(['revoked' => true]);
    }

    /**
     * Determine if the given token id is revoked or not.
     *
     * @param string $model
     * @param string $grantType
     *
     * @return bool
     */
    public static function isRevoked($model, $tokenId)
    {
        return static::instance($model)->whereId($tokenId)->whereRevoked(1)->exists();
    }

    /**
     * Authorization token.
     *
     * @param string $model
     * @param array  $data
     *
     * @return \CodexShaper\OAuth2\Server\Models\AuthCode|\CodexShaper\OAuth2\Server\Models\Client|\CodexShaper\OAuth2\Server\Models\RefreshToken|\CodexShaper\OAuth2\Server\Models\Token|\CodexShaper\OAuth2\Server\Models\User|null
     */
    public static function findToken($model, $authRequest, $user)
    {
        return static::instance($model)
                ->find($authRequest->getClient()->getIdentifier())
                ->tokens()
                ->whereUserId($user->getKey())
                ->whereRevoked(0)
                ->where('expires_at', '>', Carbon::now())
                ->latest('expires_at')
                ->first();
    }
}
