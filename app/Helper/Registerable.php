<?php

use App\Models\User;

// Checks if users can register or not
function registerable() {
    // multiUser env, check if limit is reached - if there is a limit set
    if (config('gajo.settings.multiUser')) {
        // limit reached
        if (config('gajo.settings.userLimit') > 0 && config('gajo.settings.userLimit') <= User::count()) {
            return false;
        }
    // no multiUser env set and more than one user, abort
    } else if (User::count() > 0) {
        return false;
    }

    return true;
}