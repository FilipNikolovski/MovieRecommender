<?php
/**
 * Created by PhpStorm.
 * User: filip
 * Date: 31.5.15
 * Time: 14:11
 */

namespace App\Http\Controllers;


use App\Models\Movie;

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
}