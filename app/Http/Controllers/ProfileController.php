<?php

namespace App\Http\Controllers;

class ProfileController extends Controller {
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        //$this->middleware('auth');
    }

    /**
     * Show the user profile
     *
     * @return \Illuminate\Http\Response
     */
    public function index($user) {
        echo "profile";
    }
}
