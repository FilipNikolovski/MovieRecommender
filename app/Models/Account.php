<?php
/**
 * Created by PhpStorm.
 * User: filip
 * Date: 2.6.15
 * Time: 23:18
 */

namespace App\Models;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class Account extends TmdbModel
{
    /**
     * @var Authentication
     */
    protected $auth;

    public function __construct(Client $client, Authentication $auth)
    {
        parent::__construct($client);

        $this->auth = $auth;

        $this->resource = 'account';

        $this->url = $this->API_URL . $this->resource . '/';
    }

    /**
     * Returns a list of favorite movies
     *
     * @param int $page
     * @return mixed|null
     */
    public function favoriteMovies($page = 1)
    {
        if ($this->auth->check()) {
            try {
                $this->setQueryParams(['page' => $page]);
                $req = $this->createRequest('GET', $this->url . '/' . session('session_id') . '/favorite/movies',
                    $this->params, $this->headers);
                $response = $this->client->send($req);

                return $response->json();
            } catch (RequestException $e) {
                session()->flush();

                return null;
            }
        }

        return null;
    }

    /**
     * Returns a list of rated movies
     *
     * @param int $page
     * @return mixed|null
     */
    public function ratedMovies($page = 1)
    {
        if ($this->auth->check()) {
            try {
                $this->setQueryParams(['page' => $page]);
                $req = $this->createRequest('GET', $this->url . '/' . session('session_id') . '/rated/movies',
                    $this->params, $this->headers);
                $response = $this->client->send($req);

                return $response->json();
            } catch (RequestException $e) {
                session()->flush();

                return null;
            }
        }

        return null;
    }

    /**
     * @param string $mediaType
     * @param $mediaId
     * @param $favorite
     * @return bool|mixed
     */
    public function addOrRemoveFromFavorites($mediaType = 'movie', $mediaId, $favorite)
    {
        if ($this->auth->check()) {
            try {
                $this->setQueryParams([
                    'media_type' => $mediaType,
                    'media_id' => $mediaId,
                    'favorite' => $favorite
                ]);
                $req = $this->createRequest('POST', $this->url . '/' . session('session_id') . '/favorite',
                    $this->params, $this->headers);
                $response = $this->client->send($req);

                return $response->json();
            } catch (RequestException $e) {
                session()->flush();

                return false;
            }
        }

        return false;
    }

    /**
     * @param string $mediaType
     * @param $mediaId
     * @param $watchlist
     * @return bool|mixed
     */
    public function addOrRemoveFromWatchlist($mediaType = 'movie', $mediaId, $watchlist)
    {
        if ($this->auth->check()) {
            try {
                $this->setQueryParams([
                    'media_type' => $mediaType,
                    'media_id' => $mediaId,
                    'watchlist' => $watchlist
                ]);
                $req = $this->createRequest('POST', $this->url . '/' . session('session_id') . '/watchlist',
                    $this->params, $this->headers);
                $response = $this->client->send($req);

                return $response->json();
            } catch (RequestException $e) {
                session()->flush();

                return false;
            }
        }

        return false;
    }
}