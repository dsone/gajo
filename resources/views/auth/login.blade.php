@extends('layouts.main')
@section('title', 'Login')

@section('content')
<div class="w-full px-4 pt-10 md:px-0 md:mx-auto md:w-1/3 lg:w-1/4">
    <section>
		<div class="p-10 bg-white rounded shadow-md">
			<div class="inline mx-auto">
				<h1 class="text-3xl font-bold">
					Login
				</h1>

				<div class="mt-4">
					<form method="POST" action="{{ route('login') }}">
						@csrf

						<div>
							<label class="block">
								<span class="block mb-1 font-bold">Username</span>
								<input class="block w-full form-input{{ $errors->has('email') ? ' is-danger' : '' }}" name="email" type="text" placeholder="Username" value="{{ old('email') }}" required>
							</label>

							@if ($errors->has('name'))
							<p>
								<strong>{{ $errors->first('name') }}</strong>
							</p>
							@endif
						</div>
						<div class="mt-4">
							<label class="block">
								<span class="block mb-1 font-bold">Password</span>
								<input class="block w-full form-input" name="password" type="password" value="" placeholder="Password" required>
							</label>

							@if ($errors->has('password'))
							<p class="help is-danger">
								<strong>{{ $errors->first('password') }}</strong>
							</p>
							@endif
						</div>

						<div class="mt-4">
							<label class="cursor-pointer">
								<input class="text-primary-500 form-checkbox" type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
							</label>
						</div>

						<div class="mt-8 text-center">
							<button class="btn btn-default" type="submit">Login</button>
						</div>

						<div class="mt-2 text-center">
							<a class="text-xs underline" href="{{ route('password.request') }}">Forgot Your Password?</a>
						</div>
					</form>
				</div>
			</div>
		</div>
	</section>
</div>
@endsection