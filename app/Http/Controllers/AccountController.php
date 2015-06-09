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
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;

class AccountController extends Controller
{

    /**
     * @var Account
     */
    protected $account;

    protected $movie;

    public function __construct(Account $account, Movie $movie)
    {
        parent::__construct();
        $this->middleware('auth');

        $this->account = $account;
        $this->movie = $movie;
    }

    public function getIndex()
    {
        $account = $this->account->find(session('session_id'));

        $favorites = Cache::section('favorites')->remember('favorites', 10, function () {
            return $this->account->favoriteMovies();
        });

        $watchlist = Cache::section('watchlist')->remember('watchlist', 10, function () {
            return $this->account->watchlistMovies();
        });

        $movieIds = collect(array_merge($favorites['results'], $watchlist['results']))->map(function ($movie) {
            return $movie['id'];
        })
            ->unique();

        $favorites = new LengthAwarePaginator($favorites['results'], $favorites['total_results'], 20);
        $favorites->setPath(url('/account/favorites'));

        $watchlist = new LengthAwarePaginator($watchlist['results'], $watchlist['total_results'], 20);
        $watchlist->setPath(url('/account/watchlist'));

        return view('account')
            ->with('activeTab', 'movies')
            ->with('account', $account)
            ->with('favorites', $favorites)
            ->with('watchlist', $watchlist)
            ->with('movieIds', $movieIds);
    }

    public function getTvShows()
    {
        $account = $this->account->find(session('session_id'));

        $favorites = Cache::section('favorites-tv-shows')->remember('favorites-tv-shows', 10, function () {
            return $this->account->favoriteTv();
        });

        $watchlist = Cache::section('watchlist-tv-shows')->remember('watchlist-tv-shows', 10, function () {
            return $this->account->watchlistTv();
        });

        $favorites = new LengthAwarePaginator($favorites['results'], $favorites['total_results'], 20);
        $favorites->setPath(url('/account/favorites-tv'));

        $watchlist = new LengthAwarePaginator($watchlist['results'], $watchlist['total_results'], 20);
        $watchlist->setPath(url('/account/watchlist-tv'));

        return view('account')
            ->with('activeTab', 'tv-shows')
            ->with('account', $account)
            ->with('favorites', $favorites)
            ->with('watchlist', $watchlist)
            ->with('movieIds', []);
    }

    public function getRecommended(Request $request)
    {
        $id = $request->get('id');
        $similar = Cache::section('similar-to-' . $id)->remember('similar-to-' . $id, 10, function () use ($id) {
            return $this->movie->similar($id);
        });

        return response()->json($similar, 200);
    }

    public function getFavorites(Request $request)
    {
        $page = $request->get('page');
        $page = (isset($page)) ? $page : 1;
        $key = (isset($page)) ? 'favorites-' . $page : 'favorites';
        $favorites = Cache::section('favorites')->remember($key, 10, function () use($page) {
            return $this->account->favoriteMovies($page);
        });

        $movies = new LengthAwarePaginator($favorites['results'], $favorites['total_results'], 20);
        $movies->setPath(url('/account/favorites'));

        return view('partials.account-favorites')->with('favorites', $movies);
    }

    public function getWatchlist(Request $request)
    {
        $page = $request->get('page');
        $page = (isset($page)) ? $page : 1;
        $key = (isset($page)) ? 'watchlist-' . $page : 'watchlist';
        $watchlist = Cache::section('watchlist')->remember($key, 10, function () use($page) {
            return $this->account->watchlistMovies($page);
        });

        $movies = new LengthAwarePaginator($watchlist['results'], $watchlist['total_results'], 20);
        $movies->setPath(url('/account/watchlist'));

        return view('partials.account-watchlist')->with('watchlist', $movies);
    }

    public function getFavoritesTv(Request $request)
    {
        $page = $request->get('page');
        $page = (isset($page)) ? $page : 1;
        $key = (isset($page)) ? 'favorites-tv-shows-' . $page : 'favorites-tv-shows';
        $favorites = Cache::section('favorites-tv-shows')->remember($key, 10, function () use($page) {
            return $this->account->favoriteMovies($page);
        });

        $movies = new LengthAwarePaginator($favorites['results'], $favorites['total_results'], 20);
        $movies->setPath(url('/account/favorites-tv'));

        return view('partials.account-favorites')->with('favorites', $movies);
    }

    public function getWatchlistTv(Request $request)
    {
        $page = $request->get('page');
        $page = (isset($page)) ? $page : 1;
        $key = (isset($page)) ? 'watchlist-tv-shows' . $page : 'watchlist-tv-shows';
        $watchlist = Cache::section('watchlist-tv-shows')->remember($key, 10, function () use($page) {
            return $this->account->watchlistMovies($page);
        });

        $movies = new LengthAwarePaginator($watchlist['results'], $watchlist['total_results'], 20);
        $movies->setPath(url('/account/watchlist-tv'));

        return view('partials.account-watchlist')->with('watchlist', $movies);
    }
}