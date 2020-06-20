<?php

namespace CodexShaper\OAuth2\Server\Repositories;

use CodexShaper\OAuth2\Server\Entities\User as UserEntity;
use CodexShaper\OAuth2\Server\Model;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Repositories\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function getUserEntityByUserCredentials(
        $username,
        $password,
        $grantType,
        ClientEntityInterface $clientEntity
    ) {
        $authIdentifier = Model::verifyUserForGrant($username, $password, $grantType, $clientEntity);

        if (!$authIdentifier) {
            return;
        }

        return new UserEntity($authIdentifier);
    }
}
