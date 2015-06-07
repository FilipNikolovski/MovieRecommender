<?php
/**
 * Created by PhpStorm.
 * User: filip
 * Date: 18.5.15
 * Time: 22:47
 */

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\TvShow;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

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

    public function getIndex(Request $request, TvShow $tv)
    {
        $upcoming = Cache::section('upcoming')->remember('upcoming', 10, function () {
            return $this->movie->upcoming();
        });

        $onTheAir = Cache::section('latest-tv')->remember('latest-tv', 10, function () use($tv) {
            return $tv->onTheAir();
        });

        $randomMovies = collect($upcoming['results'])->random(6);
        $randomTv = collect($onTheAir['results'])->random(6);

        return view('home')
        ->with('randomMovies', $randomMovies)
        ->with('randomTv', $randomTv);
    }

    public function getTopRated(Request $request)
    {
        if ($request->ajax()) {
            try {

                $topRated = Cache::section('top-rated')->remember('top-rated', 10, function () {
                    return $this->movie->topRated();
                });

                return response()->json($topRated['results'], 200);
            } catch (Exception $e) {
                abort(500);
            }
        }
        abort(401);
    }

    public function getPopular(Request $request)
    {
        if ($request->ajax()) {
            try {
                $popular = Cache::section('popular')->remember('popular', 10, function () {
                    return $this->movie->popular();
                });

                return response()->json($popular['results'], 200);
            } catch (Exception $e) {
                abort(500);
            }
        }
        abort(401);
    }
}