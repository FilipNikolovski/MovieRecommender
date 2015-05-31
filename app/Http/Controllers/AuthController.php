<?php
/**
 * Created by PhpStorm.
 * User: filip
 * Date: 30.5.15
 * Time: 20:24
 */

namespace App\Http\Controllers;


use App\Http\Requests\LoginRequest;
use App\Models\Authentication;
use GuzzleHttp\Exception\RequestException;

class AuthController extends Controller
{

    /**
     * @var Authentication
     */
    protected $auth;

    public function __construct(Authentication $auth)
    {
        parent::__construct();

        $this->middleware('guest');

        $this->auth = $auth;
    }

    public function postLogin(LoginRequest $request)
    {
        $res = $this->auth->login($request->get('username'), $request->get('password'));
        return response()->json($res, $res['status']);
    }
}