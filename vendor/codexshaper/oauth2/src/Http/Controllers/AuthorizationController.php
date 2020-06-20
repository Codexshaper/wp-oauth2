<?php

namespace CodexShaper\OAuth2\Server\Http\Controllers;

use Auth;
use CodexShaper\OAuth2\Server\Entities\User as UserEntity;
use CodexShaper\OAuth2\Server\Manager;
use CodexShaper\OAuth2\Server\Model;
use CodexShaper\OAuth2\Server\Models\User;
use Illuminate\Http\Request;
use League\OAuth2\Server\Exception\OAuthServerException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class AuthorizationController
{
    public function authorize(ServerRequestInterface $request, ResponseInterface $response)
    {
        try {
            // Get current user
            $user = Auth::User();
            // If user not loggedin then redirect for authenticate
            if (!$user) {
                return redirect()->route('login');
            }

            $manager = new Manager();
            $server = $manager->makeAuthorizationServer();

            // Validate the HTTP request and return an AuthorizationRequest object.
            $authRequest = $server->validateAuthorizationRequest($request);

            // Get all validate scopes from psr request
            $scopes = $this->filterScopes($authRequest);

            // Get token for current user and request client id
            $token = Model::findToken('clientModel', $authRequest, $user);

            if (($token) || Model::instance('clientModel')->isSkipsAuthorization()) {
                // Once the user has logged in set the user on the AuthorizationRequest
                $authRequest->setUser(new UserEntity($user->getKey())); // an instance of UserEntityInterface

                // Once the user has approved or denied the client update the status
                // (true = approved, false = denied)
                $authRequest->setAuthorizationApproved(true);

                // Return the HTTP redirect response
                return $server->completeAuthorizationRequest($authRequest, $response);
            }

            echo '<p>Hello</p>';
        } catch (OAuthServerException $exception) {

            // All instances of OAuthServerException can be formatted into a HTTP response
            return $exception->generateHttpResponse($response);
        }
    }

    public function filterScopes($authRequest)
    {
        return array_filter($authRequest->getScopes(), function ($scope) {
            if (Manager::isValidateScope($scope->getIdentifier())) {
                return $scope->getIdentifier();
            }
        });
    }
}
