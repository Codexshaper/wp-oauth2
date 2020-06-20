<?php

namespace CodexShaper\OAuth2\Server\Repositories;

use CodexShaper\OAuth2\Server\Model;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Repositories\ClientRepositoryInterface;

class ClientRepository implements ClientRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function getClientEntity($clientIdentifier)
    {
        $clientEntity = Model::getClientEntity($clientIdentifier);

        if (!$clientEntity instanceof ClientEntityInterface) {
            return;
        }

        return $clientEntity;
    }

    /**
     * {@inheritdoc}
     */
    public function validateClient($clientIdentifier, $clientSecret, $grantType)
    {
        return Model::validateClientCredentials($clientIdentifier, $clientSecret, $grantType);
    }
}
