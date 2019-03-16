<?php

// Checks if users can register or not
function registerable() {
    // multiUser env, check if limit is reached - if there is a limit set
    if (config('app.settings.multiUser')) {
        // limit reached
        if (config('app.settings.userLimit') > 0 && config('app.settings.userLimit') <= \Gajo\User::count()) {
            return false;
        }
    // no multiUser env set and more than one user, abort
    } else if (\Gajo\User::count() > 0) {
        return false;
    }
    return true;
}