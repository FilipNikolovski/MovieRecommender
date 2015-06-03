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
use Illuminate\Support\Facades\Cache;

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

    public function index(Request $request)
    {
        $movies = [];
        try {
            $page = $request->get('page');
            $page = (isset($page)) ? $page : 1;
            $key = (isset($page)) ? 'now-playing-' . $page : 'now-playing';

            $nowPlaying = Cache::section('now-playing')->remember($key, 10, function () use ($page) {
                return $this->movie->nowPlaying($page);
            });

            $movies = new LengthAwarePaginator($nowPlaying['results'], $nowPlaying['total_results'], 20);
            $movies->setPath(url('/movies'));
        } catch (Exception $e) {
            abort(404);
        }

        return view('movies')->with('movies', $movies);
    }

    public function getMovie($id, Request $request)
    {
        $reviews = [];
        $movie = [];
        $videos = [];

        try {
            $movie = Cache::section('movie-' . $id)->remember('movie-' . $id, 10, function () use ($id) {
                return $this->movie->find($id);
            });

            $page = $request->get('page');
            $page = (isset($page)) ? $page : 1;
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
            $similar = Cache::section('similar-to-' . $id)->remember('similar-to-' . $id, 10, function () use ($id) {
                return $this->movie->similar($id);
            });

            return response()->json($similar['results'], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'There was an error'], 500);
        }
    }

    public function favorites(Request $request)
    {
        $this->middleware('auth');
    }

    public function watchlist(Request $request)
    {
        $this->middleware('auth');
    }
}