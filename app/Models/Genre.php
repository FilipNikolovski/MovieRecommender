<?php
/**
 * Created by PhpStorm.
 * User: filip
 * Date: 20.5.15
 * Time: 23:10
 */

namespace App\Models;


use GuzzleHttp\Client;

class Genre extends TmdbModel
{

    public function __construct(Client $client)
    {
        parent::__construct($client);

        $this->resource = 'genre';

        $this->url = $this->API_URL . $this->resource . '/';
    }

    /**
     * Returns all movie genres
     *
     * @return mixed
     */
    public function movieGenres()
    {
        $req = $this->createRequest('GET', $this->url . 'movie/list', $this->params, $this->headers);
        $response = $this->client->send($req);
        return $response->json();
    }

    /**
     * Returns all tv genres
     *
     * @return mixed
     */
    public function tvGenres()
    {
        $req = $this->createRequest('GET', $this->url . 'tv/list', $this->params, $this->headers);
        $response = $this->client->send($req);
        return $response->json();
    }

    /**
     * Get movie list by particular genre, returns a paginated list
     *
     * @param $id
     * @param int $page
     * @return mixed
     */
    public function findMoviesByGenre($id, $page = 1)
    {
        $this->setQueryParams(['page' => $page]);
        $req = $this->createRequest('GET', $this->url .$id. '/movies', $this->params, $this->headers);
        $response = $this->client->send($req);
        return $response->json();
    }
}