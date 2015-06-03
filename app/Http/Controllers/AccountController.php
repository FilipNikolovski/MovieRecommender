<?php
/**
 * Created by PhpStorm.
 * User: filip
 * Date: 31.5.15
 * Time: 14:11
 */

namespace App\Http\Controllers;


use App\Models\Account;

class AccountController extends Controller
{

    /**
     * @var Account
     */
    protected $account;

    public function __construct(Account $account)
    {
        parent::__construct();
        $this->middleware('auth');

        $this->account = $account;
    }

    public function getIndex()
    {
        $account = $this->account->find(session('session_id'));
        return view('account')->with('account', $account);
    }
}