<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;

class RSSController extends Controller {
    /**
     * Show RSS
	 * 
     * @param	string	$user	The user name to display rss for
     * @param	string	$id		The RSS token string
     * @return \Illuminate\Http\Response
     */
    public function index($user, $id) {
		
    }

	/**
     * Change RSS token.
	 * 
     * @param	string	$user	The user name to change the RSS token for
     * @return \Illuminate\Http\Response
     */
    public function changeToken() {
		try {
			$user = Auth::user();
			$user->options->rss = Str::random(42);
			$user->options->save();

			return response()->json([
					'error' => false,
					'data' => $user->options->rss
				]);
		} catch (\Exception $e) {
			return response()->json([
					'error' => true,
					'message' => $e->getMessage()
				]);
		}
    }
}
