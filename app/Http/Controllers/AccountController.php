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
            return $this->account->watchlist();
        });
        $movieIds = collect(array_merge($favorites['results'], $watchlist['results']))->map(function ($movie) {
            return $movie['id'];
        })
            ->unique();

        return view('account')
            ->with('account', $account)
            ->with('favorites', $favorites)
            ->with('watchlist', $watchlist)
            ->with('movieIds', $movieIds);
    }

    public function getRecommended(Request $request)
    {
        $id = $request->get('id');
        $similar = Cache::section('similar-to-' . $id)->remember('similar-to-' . $id, 10, function () use ($id) {
            return $this->movie->similar($id);
        });

        return response()->json($similar, 200);
    }
}