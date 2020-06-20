<?php

namespace CodexShaper\OAuth2\Server\Repositories;

use CodexShaper\OAuth2\Server\Entities\AccessToken as AccessTokenEntity;
use CodexShaper\OAuth2\Server\Model;
use Exception;
use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Exception\UniqueTokenIdentifierConstraintViolationException;
use League\OAuth2\Server\Repositories\AccessTokenRepositoryInterface;

class AccessTokenRepository implements AccessTokenRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function getNewToken(ClientEntityInterface $clientEntity, array $scopes, $userIdentifier = null)
    {
        return new AccessTokenEntity($userIdentifier, $scopes, $clientEntity);
    }

    /**
     * {@inheritdoc}
     */
    public function persistNewAccessToken(AccessTokenEntityInterface $accessTokenEntity)
    {
        try {
            Model::storeAccessToken($accessTokenEntity);
        } catch (UniqueTokenIdentifierConstraintViolationException $ex) {
            throw new Exception($ex->getMessage());
        }
    }

    /**
     * {@inheritdoc}
     */
    public function revokeAccessToken($tokenId)
    {
        Model::revoke('tokenModel', $tokenId);
    }

    /**
     * {@inheritdoc}
     */
    public function isAccessTokenRevoked($tokenId)
    {
        return Model::isRevoked('tokenModel', $tokenId);
    }
}
