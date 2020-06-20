<?php

namespace CodexShaper\OAuth2\Server\Repositories;

use CodexShaper\OAuth2\Server\Entities\Scope as ScopeEntity;
use CodexShaper\OAuth2\Server\Manager;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Repositories\ScopeRepositoryInterface;

class ScopeRepository implements ScopeRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function getScopeEntityByIdentifier($identifier)
    {
        if (Manager::hasScope($identifier)) {
            return new ScopeEntity($identifier);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function finalizeScopes(
        array $scopes,
        $grantType,
        ClientEntityInterface $clientEntity,
        $userIdentifier = null
    ) {
        return Manager::filterScopes($scopes, $grantType, $clientEntity, $userIdentifier);
    }
}
