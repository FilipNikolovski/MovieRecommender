<?php
/**
 * Created by PhpStorm.
 * User: filip
 * Date: 20.5.15
 * Time: 22:58
 */

namespace App\Models;


use GuzzleHttp\Client;

class Authentication extends TmdbModel
{

    public function __construct(Client $client)
    {
        parent::__construct($client);

        $this->resource = 'authentication';

        $this->url = $this->API_URL . $this->resource . '/';
    }

    /**
     * Generate a valid request token for user based authentication
     *
     * @return mixed
     */
    public function generateToken()
    {
        $req = $this->createRequest('GET', $this->url . 'token/new', $this->params, $this->headers);
        $response = $this->client->send($req);
        return $response->json();
    }

    /**
     * Authenticate user with TMDb username and password
     *
     * @param $requestToken
     * @param $username
     * @param $password
     * @return mixed
     */
    public function validateToken($requestToken, $username, $password)
    {
        $data = [
            'username' => $username,
            'password' => $password,
            'request_token' => $requestToken
        ];

        $this->setQueryParams($data);
        $req = $this->createRequest('GET', $this->url .'token/validate_with_login', $this->params, $this->headers);
        $response = $this->client->send($req);
        return $response->json();
    }

    /**
     * Generate a session id for user based authentication
     *
     * @param $requestToken
     * @return mixed
     */
    public function generateSession($requestToken)
    {
        $data = [ 'request_token' => $requestToken ];

        $this->setQueryParams($data);
        $req = $this->createRequest('GET', $this->url .'session/new', $this->params, $this->headers);
        $response = $this->client->send($req);
        return $response->json();
    }

    /**
     * Check if the user is logged in.
     *
     * @return mixed
     */
    public function check()
    {
        return session()->has('session_id');
    }

}