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

    protected $auth;

    public function __construct(Authentication $auth)
    {
        parent::__construct();

        $this->middleware('guest');

        $this->auth = $auth;
    }

    public function postLogin(LoginRequest $request)
    {
        try {
            $requestToken = $this->auth->generateToken();

            if (!empty($requestToken['success'])) {
                $this->auth->validateToken($requestToken['request_token'], $request->get('username'), $request->get('password'));

                $session = $this->auth->generateSession($requestToken['request_token']);
                session(['session_id' => $session['session_id'], 'username' => $request->get('username')]);

                return response()->json(['message' => 'Login successful', 'session_id' => $session['session_id']], 200);
            }
            return response()->json(['message' => 'There was an error. Please try again.'], 500);
        } catch (RequestException $e) {
            $res = $e->getResponse();
            return response()->json(['message' => $res->getReasonPhrase()], $res->getStatusCode());
        }
    }
}