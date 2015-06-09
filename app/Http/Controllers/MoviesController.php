<?php
/**
 * Created by PhpStorm.
 * User: filip
 * Date: 31.5.15
 * Time: 14:11
 */

namespace App\Http\Controllers;


use App\Models\Account;
use App\Models\Movie;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

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
            Log::error($e->getMessage());
            abort(404);
        }

        return view('movie.movies')->with('movies', $movies);
    }

    public function getMovie($id, Request $request)
    {
        $data = [];
        $accountStates = [];
        try {
            $page = $request->get('page');
            $page = (isset($page)) ? $page : 1;
            $data = Cache::section('movie-' . $id)->remember('movie-' . $id, 10, function () use ($id, $page) {
                $data['movie'] = $this->movie->find($id);
                $data['reviews'] = $this->movie->reviews($id, $page);
                $data['videos'] = $this->movie->videos($id);

                return $data;
            });


            $sessionId = (session()->has('session_id')) ? session('session_id') : false;
            if ($sessionId) {
                $accountStates = $this->movie->accountStates($id, $sessionId);
            }

        } catch (Exception $e) {
            abort(404);
        }

        $reviews = new LengthAwarePaginator($data['reviews']['results'], $data['reviews']['total_results'], 20);
        $reviews->setPath(url('/movie/' . $id));

        return view('movie.movie-details')
            ->with('movie', $data['movie'])
            ->with('videos', $data['videos'])
            ->with('reviews', $reviews)
            ->with('accountStates', $accountStates);
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

    public function postRating(Request $request)
    {
        $this->middleware('auth');
        $result = $this->movie->rateMovie($request->get('score'), $request->get('movie_id'));
        if ($request->ajax()) {
            return response($result, 200);
        }

        return redirect()->back();
    }

    public function postFavorites(Request $request, Account $account)
    {
        $this->middleware('auth');
        $result = $account->addOrRemoveFromFavorites($request->get('media_type'), $request->get('media_id'),
            $request->get('favorite'));
        if ($request->ajax()) {
            return response($result, 200);
        }

        return redirect()->back();
    }

    public function postWatchlist(Request $request, Account $account)
    {
        $this->middleware('auth');
        $result = $account->addOrRemoveFromWatchlist($request->get('media_type'), $request->get('media_id'),
            $request->get('watchlist'));
        if ($request->ajax()) {
            return response($result, 200);
        }

        return redirect()->back();
    }

    public function getSearch(Request $request)
    {
        if ($request->ajax()) {
            $page = $request->get('page');
            $page = (isset($page)) ? $page : 1;
            $movies = $this->movie->search($request->get('search'), $page);

            return view('partials.search-movie-items')->with('movies', $movies);
        }

        $query = $request->get('search');
        $movies = [];

        if (isset($query)) {
            $movies = $this->movie->search($query);
        }

        return view('search')
            ->with('movies', $movies)
            ->with('query', $query);
    }

}