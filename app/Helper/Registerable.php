<?php

use App\Models\User;

// Checks if users can register or not
function registerable() {
    // multiUser env, check if limit is reached - if there is a limit set
    if (config('gajo.settings.multiUser') !== false) {
        // no limit on users
		if (config('gajo.settings.multiUser') === true) {
			return true;
		// limit not yet reached
		} else if (User::count() < config('gajo.settings.multiUser')) {
            return true;
        }

		return false;
    // no multiUser env set and more than one user, abort
    } else if (User::count() > 0) {
        return false;
    }

    return true;
}