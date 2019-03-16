<?php

namespace Gajo\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Gajo\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller {
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers {
        login as protected parentLogin;
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/profile/';

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username() {
        return 'name';
    }

    /**
     * Redirects user to their profile after registration/login
     */
    public function redirectPath() {
        return '/profile/'. request()->user()->name;
    }

    public function login(Request $request) {
        if (\Config::get('app.env') === 'local') {
            $u = \Gajo\User::first();
            \Auth::login($u);
            return redirect()->route('user-profile', ['user' => $u->name]);
        }
        return $this->parentLogin($request);
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
