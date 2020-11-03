<?php

namespace App\Http\Controllers;

use Auth;
use Carbon\Carbon;
use App\Models\User;

class ProfileController extends Controller {
    /**
     * Show the user profile
     *
     * @return \Illuminate\Http\Response
     */
    public function index($user) {
		$authUser = Auth::user();
		// Auth'd user tries to access own profile, but has no verified mail
		if ($authUser && $authUser->name === $user && !$authUser->hasVerifiedEmail()) {
			return redirect()->route('verification.notice', 303);
		}

		// User or 404
		$userProfile = $authUser && $authUser->name === $user ? $authUser : User::where('name', $user)->firstOrFail();
		$ownProfile = $authUser && $authUser->name === $user;
		
		// Other user's profile, but that user has no verified mail or is in privatemode
		if (!$userProfile->hasVerifiedEmail() || (!$ownProfile && $userProfile->options->privateProfile)) {
			abort(404);
		}

		$types = null;
		if (!$ownProfile) {
			$types = $userProfile->types()->whereHas('entries')->with('entries', function($q) use($userProfile) {
						$q->where('visibility', '>=', config('gajo.settings.list.visibility.public'));

						if ($userProfile->options->hideReleased) {
							$q->where('release_at', '>', Carbon::now()->startOfDay()->format('c'));
						}
						if ($userProfile->options->hideTBA) {
							$q->where('ident_2', '!=', 'TBA')->where('entries.release_at', '!=', null);
						}
						$q->orderBy('ident_1');
					});
			$types = $types->get();
		} else {
			$types = $authUser->types()->with([ 'entries' ])->get();
		}

        return view('user.profile', [
				'user'			=> $userProfile,
				'types'			=> $types,
				'ownProfile'	=> $ownProfile,
			]);
    }
}
