<?php
/**
 * Created by PhpStorm.
 * User: filip
 * Date: 18.5.15
 * Time: 22:27
 */
namespace App\Models;

use GuzzleHttp\Client;

abstract class TmdbModel
{

    /**
     * @var string
     */
    protected $API_URL;

    /**
     * @var string
     */
    protected $API_KEY;

    /**
     * @var Client
     */
    protected $client;

    /**
     * @var string
     */
    protected $resource;

    /**
     * @var string
     */
    protected $url;

    /**
     * @var array
     */
    protected $params;

    /**
     * @var array
     */
    protected $headers;

    public function __construct(Client $client)
    {
        $this->client = $client;

        $this->API_URL = env('API_URL');

        $this->API_KEY = env('API_KEY');

        $this->params = ['api_key' => $this->API_KEY];

        $this->headers = ['Content-Type' => 'application/json', 'Accept' => 'application/json'];
    }

    public function createRequest($method = 'GET', $url, $params, array $headers)
    {
        $request = $this->client->createRequest($method, $url);
        $request->setHeaders($headers);
        $request->setQuery($params);

        return $request;
    }

    /**
     * Sets the query parameters
     *
     * @param array $params
     */
    protected function setQueryParams(array $params)
    {
        $this->params = array_merge($this->params, $params);
    }

    /**
     * Resets the query parameters
     */
    protected function resetParams()
    {
        $this->params = ['api_key' => $this->API_KEY];
    }
}