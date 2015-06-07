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

    /**
     * Returns upcoming movies with paginated results
     * @return mixed
     */
    public function latest()
    {
        $req = $this->createRequest('GET', $this->url . 'latest', $this->params, $this->headers);
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
}