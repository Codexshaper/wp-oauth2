<?php

namespace CodexShaper\OAuth2\Server\Http\Responses;

use Nyholm\Psr7\Response;

class ServerResponse
{
    public static function getPsrServerResponse()
    {
        return new Response();
    }
}
