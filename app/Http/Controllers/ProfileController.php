<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\User;

class ProfileController extends Controller {
    /**
     * Show the user profile
     *
     * @return \Illuminate\Http\Response
     */
    public function index($user) {
		// Profile must exist, or 404
		$userProfile = User::where('name', $user)->with([ 'types', 'types.entries' ])->firstOrFail();

		$authUser = Auth::user();
		// Auth'd user tries to access own profile, but has no verified mail
		if ($authUser && $authUser->name === $user && !$authUser->hasVerifiedEmail()) {
			return redirect()->route('verification.notice', 303);
		}

		// Other user's profile, but that user has no verified mail
		if (!$userProfile->hasVerifiedEmail()) {
			abort(404);
		}

        return view('user.profile', [
				'user'			=> $userProfile,
				'types'			=> $userProfile->types,
				'ownProfile'	=> $userProfile->name == Auth::user()->name,
			]);
    }
}
