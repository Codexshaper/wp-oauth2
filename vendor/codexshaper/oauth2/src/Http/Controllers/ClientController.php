<?php

namespace CodexShaper\OAuth2\Server\Http\Controllers;

use CodexShaper\OAuth2\Server\Manager;
use CodexShaper\OAuth2\Server\Model;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ClientController extends Controller
{
    public function issueAccessToken(ServerRequestInterface $request, ResponseInterface $response)
    {
        $manager = new Manager();
        $server = $manager->makeAuthorizationServer();

        try {
            $response = $server->respondToAccessTokenRequest($request, $response);

            return wp_send_json(json_decode($response->getBody()), 200);
        } catch (\Exception $e) {
            return $exception->generateHttpResponse($response);
        }
    }

    public function all(Request $request)
    {
        $clients = Model::instance('clientModel')
                   ->whereUserId($request->user()->getKey())
                   ->orderBy('updated_at', 'DESC')
                   ->get()
                   ->makeVisible('secret');

        return wp_send_json(['clients' => $clients]);
    }

    public function store(Request $request)
    {
        try {
            $client = Model::instance('clientModel');

            $client->user_id = $request->user()->getKey();
            $client->name = $request->name;
            $client->redirect = !empty($request->redirect) ? $request->redirect : 'http://localhost';
            $client->secret = Str::random(40);
            $client->personal_access_client = $request->type == 'personal_access' ? 1 : 0;
            $client->password_client = $request->type == 'password' ? 1 : 0;
            $client->authorization_code_client = $request->type == 'authorization_code' ? 1 : 0;
            $client->revoked = 0;

            $client->save();
        } catch (\Exception $ex) {
            return wp_send_json(['errors' => [$ex->getMessage()]], 404);
        }

        return $this->all($request);
    }

    public function update(Request $request)
    {
        try {
            $client = Model::instance('clientModel')->find($request->id);

            $client->user_id = $request->user()->getKey();
            $client->name = $request->name;
            $client->redirect = !empty($request->redirect) ? $request->redirect : 'http://localhost';
            // $client->secret = Str::random(40);
            $client->personal_access_client = $request->type == 'personal_access' ? 1 : 0;
            $client->password_client = $request->type == 'password' ? 1 : 0;
            $client->authorization_code_client = $request->type == 'authorization_code' ? 1 : 0;
            $client->revoked = 0;

            $client->save();
        } catch (\Exception $ex) {
            return wp_send_json(['errors' => [$ex->getMessage()]], 404);
        }

        return $this->all($request);
    }

    public function destroy(Request $request)
    {
        $client = Model::instance('clientModel')->whereId($request->id)->whereUserId($request->user()->getKey())->first();

        if ($client) {
            $client->tokens()->delete();
            $client->delete();

            return $this->all($request);
        }

        return wp_send_json(['errors' => ['There is no client.']], 404);
    }
}
