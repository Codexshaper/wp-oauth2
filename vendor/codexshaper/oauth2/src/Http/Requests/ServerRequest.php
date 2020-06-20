<?php

namespace CodexShaper\OAuth2\Server\Http\Requests;

use Nyholm\Psr7\Factory\Psr17Factory;
use Symfony\Bridge\PsrHttpMessage\Factory\PsrHttpFactory;
use Symfony\Component\HttpFoundation\Request;

class ServerRequest
{
    public static function getPsrServerRequest()
    {
        if (class_exists(Psr17Factory::class) && class_exists(PsrHttpFactory::class)) {
            $psr17Factory = new Psr17Factory();

            return (new PsrHttpFactory($psr17Factory, $psr17Factory, $psr17Factory, $psr17Factory))
                ->createRequest(Request::createFromGlobals());
        }

        throw new Exception('Unable to resolve PSR request. Please install symfony/psr-http-message-bridge and nyholm/psr7.');
    }
}
