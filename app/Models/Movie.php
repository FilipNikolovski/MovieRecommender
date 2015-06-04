<?php
/**
 * Created by PhpStorm.
 * User: filip
 * Date: 18.5.15
 * Time: 22:48
 */

namespace App\Models;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;

class Movie extends TmdbModel
{

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
        $req = $this->createRequest('GET', $this->url . 'upcoming', $this->params, $this->headers);
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
        $req = $this->createRequest('GET', $this->url . 'top_rated', $this->params, $this->headers);
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
        $req = $this->createRequest('GET', $this->url . 'now_playing', $this->params, $this->headers);
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
        $req = $this->createRequest('GET', $this->url . 'popular', $this->params, $this->headers);
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
        $req = $this->createRequest('GET', $this->url . $id . '/similar', $this->params, $this->headers);
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
        $req = $this->createRequest('GET', $this->url . $id . '/reviews', $this->params, $this->headers);
        $response = $this->client->send($req);

        return $response->json();
    }

    /**
     * Returns the movie videos
     *
     * @param $id
     * @return mixed
     */
    public function videos($id)
    {
        $req = $this->createRequest('GET', $this->url . $id . '/videos', $this->params, $this->headers);
        $response = $this->client->send($req);

        return $response->json();
    }

    /**
     * Check the account states for the movie (has user rated, added on watchlist or added in favorites)
     *
     * @param $movieId
     * @param $sessionId
     * @return mixed
     */
    public function accountStates($movieId, $sessionId)
    {
        $this->setQueryParams(['session_id' => $sessionId]);
        $req = $this->createRequest('GET', $this->url . $movieId . '/account_states', $this->params, $this->headers);
        $response = $this->client->send($req);

        return $response->json();
    }

    public function rateMovie($score, $id)
    {
        try {
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $this->url . $id . '/rating?api_key=' . $this->API_KEY . '&session_id=' . session('session_id'));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HEADER, false);

            curl_setopt($ch, CURLOPT_POST, true);

            $value = floor($score * 2) / 2;
            curl_setopt($ch, CURLOPT_POSTFIELDS, "{
                    \"value\": ". $value ."
                }");

            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                "Accept: application/json",
                "Content-Type: application/json"
            ));

            $response = curl_exec($ch);
            curl_close($ch);

            return $response;
        }
        catch(RequestException $e) {
            Log::error($e->getMessage() . '\nLine:' . $e->getLine() . '\nStack Trace:' . $e->getTraceAsString());
            return false;
        }
    }
}