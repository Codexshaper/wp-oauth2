<?php

namespace CodexShaper\OAuth2\Server;

use CodexShaper\OAuth2\Server\Repositories\AccessTokenRepository;
use League\OAuth2\Server\CryptKey;
use League\OAuth2\Server\ResourceServer as LeagueResourServer;

class ResourceServer
{
    public function __construct()
    {
        return new LeagueResourServer(
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
}
