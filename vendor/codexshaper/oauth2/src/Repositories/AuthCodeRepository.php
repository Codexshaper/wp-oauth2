<?php

namespace CodexShaper\OAuth2\Server\Repositories;

use CodexShaper\OAuth2\Server\Entities\AuthCode as AuthCodeEntity;
use CodexShaper\OAuth2\Server\Model;
use Exception;
use League\OAuth2\Server\Entities\AuthCodeEntityInterface;
use League\OAuth2\Server\Exception\UniqueTokenIdentifierConstraintViolationException;
use League\OAuth2\Server\Repositories\AuthCodeRepositoryInterface;

class AuthCodeRepository implements AuthCodeRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function getNewAuthCode()
    {
        return new AuthCodeEntity();
    }

    /**
     * {@inheritdoc}
     */
    public function persistNewAuthCode(AuthCodeEntityInterface $authCodeEntity)
    {
        try {
            Model::storeAuthCode($authCodeEntity);
        } catch (UniqueTokenIdentifierConstraintViolationException $ex) {
            throw new Exception($ex->getMessage());
        }
    }

    /**
     * {@inheritdoc}
     */
    public function revokeAuthCode($codeId)
    {
        Model::revoke('authCodeModel', $tokenId);
    }

    /**
     * {@inheritdoc}
     */
    public function isAuthCodeRevoked($codeId)
    {
        return Model::isRevoked('authCodeModel', $tokenId);
    }
}
