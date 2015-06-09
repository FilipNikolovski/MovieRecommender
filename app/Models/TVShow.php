<?php
namespace App\Models;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;

class TvShow extends TmdbModel
{

    public function __construct(Client $client)
    {
        parent::__construct($client);

        $this->resource = 'tv';

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

    public function videos($id) {
        $req = $this->createRequest('GET', $this->url . $id . '/videos', $this->params, $this->headers);
        $response = $this->client->send($req);

        return $response->json();
    }

    /**
     * Returns upcoming movies with paginated results
     *
     * @param int $page
     * @return mixed
     */
    public function onTheAir($page = 1)
    {
        $this->setQueryParams(['page' => $page]);
        $req = $this->createRequest('GET', $this->url . 'on_the_air', $this->params, $this->headers);
        $response = $this->client->send($req);

        return $response->json();
    }

    public function TopRated($page) {
        $this->setQueryParams(['page' => $page]);
        $req = $this->createRequest('GET', $this->url . 'top_rated', $this->params, $this->headers);
        $response = $this->client->send($req);

        return $response->json();
    }

    public function rateTvShow($score, $id) {
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