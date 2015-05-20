<?php
/**
 * Created by PhpStorm.
 * User: filip
 * Date: 18.5.15
 * Time: 22:47
 */

namespace App\Http\Controllers;

use App\Models\Movie;

class HomeController extends Controller
{

    /**
     * @var Movie
     */
    protected $movie;

    public function __construct(Movie $movie)
    {
        $this->movie = $movie;
    }

    public function getIndex()
    {
        return view('home');
    }
}