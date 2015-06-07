<?php
/**
 * Created by PhpStorm.
 * User: filip
 * Date: 31.5.15
 * Time: 14:12
 */

namespace App\Http\Controllers;

use App\Models\TVShow;
use Exception;
use Illuminate\Http\Request;

class TvShowsController extends Controller
{
	/**
     * @var TVShow;
     */
    protected $tvShow;

    public function __construct()
    {
        parent::__construct();

    }

    public function getIndex(Request $request)
    {
      	
        return view('tv-shows');
    }
}