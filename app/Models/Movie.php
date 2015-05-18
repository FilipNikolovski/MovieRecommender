<?php
/**
 * Created by PhpStorm.
 * User: filip
 * Date: 18.5.15
 * Time: 22:48
 */

namespace App\Models;

use GuzzleHttp\Client;

class Movie extends TmdbModel
{
    /**
     * @var string
     */
    protected $resource;

    public function __construct(Client $client)
    {
        parent::__construct($client);

        $this->resource = 'movie';

        $this->url = $this->API_URL . $this->resource . '/';
    }

    /**
     * Returns the specified resource by id
     *
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        $req = $this->createRequest('GET', $this->url . $id, $this->params, $this->headers);
        $response = $this->client->send($req);
        return $response->json();
    }

    /**
     * Returns upcoming movies with paginated results
     *
     * @param int $page
     * @return mixed
     */
    public function upcoming($page = 1)
    {
        $this->setQueryParams(['page' => $page]);
        $req = $this->createRequest('GET', $this->url .'upcoming', $this->params, $this->headers);
        $response = $this->client->send($req);
        return $response->json();
    }

    /**
     * Returns top rated movies with paginated results
     *
     * @param int $page
     * @return mixed
     */
    public function topRated($page = 1)
    {
        $this->setQueryParams(['page' => $page]);
        $req = $this->createRequest('GET', $this->url .'top_rated', $this->params, $this->headers);
        $response = $this->client->send($req);
        return $response->json();
    }

    /**
     * Returns movies that are currently playing, with paginated results
     *
     * @param int $page
     * @return mixed
     */
    public function nowPlaying($page = 1)
    {
        $this->setQueryParams(['page' => $page]);
        $req = $this->createRequest('GET', $this->url .'now_playing', $this->params, $this->headers);
        $response = $this->client->send($req);
        return $response->json();
    }

    /**
     * Returns popular movies with paginated results
     *
     * @param int $page
     * @return mixed
     */
    public function popular($page = 1)
    {
        $this->setQueryParams(['page' => $page]);
        $req = $this->createRequest('GET', $this->url .'popular', $this->params, $this->headers);
        $response = $this->client->send($req);
        return $response->json();
    }

    /**
     * Returns similar movies
     *
     * @param $id
     * @param int $page
     * @return mixed
     */
    public function similar($id, $page = 1)
    {
        $this->setQueryParams(['page' => $page]);
        $req = $this->createRequest('GET', $this->url .$id. '/similar', $this->params, $this->headers);
        $response = $this->client->send($req);
        return $response->json();
    }

    /**
     *Returns the movie reviews by users
     *
     * @param $id
     * @param int $page
     * @return mixed
     */
    public function reviews($id, $page = 1)
    {
        $this->setQueryParams(['page' => $page]);
        $req = $this->createRequest('GET', $this->url .$id. '/reviews', $this->params, $this->headers);
        $response = $this->client->send($req);
        return $response->json();
    }

}