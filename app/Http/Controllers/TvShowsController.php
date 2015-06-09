<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\TVShow;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;

class TvShowsController extends Controller
{
	/**
     * @var TVShow;
     */
    protected $tvShow;

    public function __construct(TVShow $tvShow)
    {
        parent::__construct();
        $this->tvShow = $tvShow;
    }

    public function index(Request $request)
    {
    	$tvShows = [];
        try {
            $page = $request->get('page');
            $page = (isset($page)) ? $page : 1;
            $key = (isset($page)) ? 'top_rated-' . $page : 'top_rated';

            $topRated = Cache::section('top_rated')->remember($key, 10, function () use ($page) {
                return $this->tvShow->topRated($page);
            });

            $tvShows = new LengthAwarePaginator($topRated['results'], $topRated['total_results'], 20);
            $tvShows->setPath(url('/tv-shows'));
        } catch (Exception $e) {
            Log::error($e->getMessage());
            abort(404);
        }

        return view('tv-shows')->with('tvShows', $tvShows);
    }

    public function getTvShow($id, Request $request)
    {
        $data = [];
        $accountStates = [];
        try {
            $page = $request->get('page');
            $page = (isset($page)) ? $page : 1;
            
            $data = Cache::section('tv-' . $id)->remember('tv-' . $id, 10, function () use ($id, $page) {
                $data['tv'] = $this->tvShow->find($id);
                $data['videos'] = $this->tvShow->videos($id);

                return $data;
            });

            $sessionId = (session()->has('session_id')) ? session('session_id') : false;
            if ($sessionId) {
                $accountStates = $this->tvShow->accountStates($id, $sessionId);
            }

        } catch (Exception $e) {
            abort(404);
        }

        return view('tv-shows-details')
            ->with('tvShow', $data['tv'])
            ->with('videos', $data['videos'])
            ->with('accountStates', $accountStates);
    }

    public function postRating(Request $request)
    {
        $this->middleware('auth');
        $result = $this->tvShow->rateTvShow($request->get('score'), $request->get('tv_id'));
        
        if ($request->ajax()) {
            return response($result, 200);
        }

        return redirect()->back();
    }
}