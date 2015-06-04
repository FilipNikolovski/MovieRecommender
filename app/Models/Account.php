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
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

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

        $this->url = $this->API_URL . $this->resource;
    }

    public function find($sessionId)
    {
        try {
            $this->setQueryParams(['session_id' => $sessionId]);
            $req = $this->createRequest('GET', $this->url,
                $this->params, $this->headers);

            $response = $this->client->send($req);

            return $response->json();
        } catch (RequestException $e) {
            session()->flush();

            return null;
        }
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
                //Guzzle has problems with sending json body so had to use curl instead
                $ch = curl_init();

                curl_setopt($ch, CURLOPT_URL, $this->url . '/' . session('session_id') . '/favorite?api_key=' . $this->API_KEY . '&session_id=' . session('session_id'));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HEADER, false);

                curl_setopt($ch, CURLOPT_POST, true);

                curl_setopt($ch, CURLOPT_POSTFIELDS, "{
                    \"media_type\": \"". $mediaType ."\",
                    \"media_id\": ". $mediaId .",
                    \"favorite\": ". $favorite ."
                }");

                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    "Accept: application/json",
                    "Content-Type: application/json"
                ));

                $response = curl_exec($ch);
                curl_close($ch);

                Cache::section('favorites')->flush();

                return $response;
            } catch (RequestException $e) {
                Log::error($e->getMessage() . '\nLine:' . $e->getLine() . '\nStack Trace:' . $e->getTraceAsString() . '\nRequest:' . $e->getRequest());

                return ['status' => 'error', 'message' => 'Something went wrong'];
            }
        }

        return ['status' => 'error', 'message' => 'Something went wrong'];
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
                //Guzzle has problems with sending json body so had to use curl instead
                $ch = curl_init();

                curl_setopt($ch, CURLOPT_URL, $this->url . '/' . session('session_id') . '/watchlist?api_key=' . $this->API_KEY . '&session_id=' . session('session_id'));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HEADER, false);

                curl_setopt($ch, CURLOPT_POST, true);

                curl_setopt($ch, CURLOPT_POSTFIELDS, "{
                    \"media_type\": \"". $mediaType ."\",
                    \"media_id\": ". $mediaId .",
                    \"watchlist\": ". $watchlist ."
                }");

                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    "Accept: application/json",
                    "Content-Type: application/json"
                ));

                $response = curl_exec($ch);
                curl_close($ch);

                Cache::section('favorites')->flush();

                return json_decode($response);
            } catch (RequestException $e) {
                Log::error($e->getMessage() . '\nLine:' . $e->getLine() . '\nStack Trace:' . $e->getTraceAsString());

                return ['status' => 'error', 'message' => 'Something went wrong'];
            }
        }

        return ['status' => 'error', 'message' => 'Something went wrong'];
    }
}