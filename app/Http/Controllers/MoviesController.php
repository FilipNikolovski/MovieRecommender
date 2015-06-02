<?php
/**
 * Created by PhpStorm.
 * User: filip
 * Date: 31.5.15
 * Time: 14:11
 */

namespace App\Http\Controllers;


use App\Models\Movie;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class MoviesController extends Controller
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

    public function getIndex($id, Request $request)
    {
        $reviews = [];
        $movie = [];
        $videos = [];

        try {
            $page = $request->get('page');
            $page = (isset($page)) ? $page : 1;
            $movie = $this->movie->find($id);
            $reviews = $this->movie->reviews($id, $page);
            $videos = $this->movie->videos($id);
        } catch (Exception $e) {
            abort(404);
        }

        $reviews = new LengthAwarePaginator($reviews['results'], $reviews['total_results'], 20);
        $reviews->setPath(url('/movie/' . $id));

        return view('movie-details')
            ->with('movie', $movie)
            ->with('videos', $videos)
            ->with('reviews', $reviews);
    }

    public function getSimilarMovies($id)
    {
        try {
            $similar = $this->movie->similar($id);

            return response()->json($similar['results'], 200);
        } catch (Exception $e) {
            abort(500);
        }
    }

    public function postAddToFavorites(Request $request)
    {

    }
}