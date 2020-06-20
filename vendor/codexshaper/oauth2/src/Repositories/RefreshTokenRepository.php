<?php

namespace CodexShaper\OAuth2\Server\Repositories;

use CodexShaper\OAuth2\Server\Entities\RefreshToken as RefreshTokenEntity;
use CodexShaper\OAuth2\Server\Model;
use Exception;
use League\OAuth2\Server\Entities\RefreshTokenEntityInterface;
use League\OAuth2\Server\Exception\UniqueTokenIdentifierConstraintViolationException;
use League\OAuth2\Server\Repositories\RefreshTokenRepositoryInterface;

class RefreshTokenRepository implements RefreshTokenRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function getNewRefreshToken()
    {
        return new RefreshTokenEntity();
    }

    /**
     * {@inheritdoc}
     */
    public function persistNewRefreshToken(RefreshTokenEntityInterface $refreshTokenEntity)
    {
        try {
            Model::storeRefreshToken($refreshTokenEntity);
        } catch (UniqueTokenIdentifierConstraintViolationException $ex) {
            throw new Exception($ex->getMessage());
        }
    }

    /**
     * {@inheritdoc}
     */
    public function revokeRefreshToken($tokenId)
    {
        Model::revoke('refreshTokenModel', $tokenId);
    }

    /**
     * {@inheritdoc}
     */
    public function isRefreshTokenRevoked($tokenId)
    {
        return Model::isRevoked('refreshTokenModel', $tokenId);
    }
}
