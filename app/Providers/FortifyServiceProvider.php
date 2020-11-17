<?php

namespace App\Providers;

use App\Models\User;
use Laravel\Fortify\Fortify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Actions\Fortify\CreateNewUser;
use Illuminate\Support\ServiceProvider;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

		Fortify::loginView(function() {
			return view('auth.login');
		});

		Fortify::registerView(function() {
			if (!registerable()) { return abort(404); }

			return view('auth.register.register');
		});
		Fortify::verifyEmailView(function() {
			return view('auth.register.verify-email');
		});

		Fortify::requestPasswordResetLinkView(function() {
			return view('auth.passwords.forgot-password');
		});
		Fortify::resetPasswordView(function($request) {
			return view('auth.passwords.reset-password', ['request' => $request]);
		});
    }
}
