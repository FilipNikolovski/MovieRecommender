<?php
/**
 * Created by PhpStorm.
 * User: filip
 * Date: 18.5.15
 * Time: 22:47
 */

namespace App\Http\Controllers;

use App\Models\Movie;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class HomeController extends Controller
{

    /**
     * @var Movie
     */
    protected $movie;

    public function __construct(Movie $movie)
    {
        parent::__construct();

        $this->movie = $movie;
    }

    /**
     * @param Request $request
     * @return $this
     */
    public function getIndex(Request $request)
    {
        $nowPlaying = [];
        try {
            $page = $request->get('page');
            $page = (isset($page)) ? $page : 1;
            $nowPlaying = $this->movie->nowPlaying($page);
        }
        catch(Exception $e) {
            abort(404);
        }
        $movies = new LengthAwarePaginator($nowPlaying['results'], $nowPlaying['total_results'], 20);
        $movies->setPath(url('/'));
        return view('home')->with('movies', $movies);
    }
}