@extends('layouts.main')
@section('title', 'Password reset')

@section('content')
<div class="w-full px-4 pt-10 md:px-0 md:mx-auto md:w-1/3 lg:w-1/4">
    <section>
		<div class="p-10 bg-white rounded shadow-md">
			<div class="inline mx-auto">
				<h1 class="text-3xl font-bold">
					Reset Password
				</h1>

				<div class="mt-4">
					<form method="POST" action="{{ route('password.update') }}">
						@csrf

						<input type="hidden" name="token" value="{{ $request->route('token') }}">

						<div>
							<label class="block">
								<span class="block">E-Mail Address</span>
								<input class="block w-full form-input{{ $errors->has('email') ? ' is-danger' : '' }}" type="text" placeholder="E-Mail Address" value="{{ $request->email ?? old('email') }}" name="email" required>
							</label>

							@if ($errors->has('email'))
							<p>
								<strong>{{ $errors->first('email') }}</strong>
							</p>
							@endif
						</div>

						<div class="mt-4">
							<label class="block">
								<span class="block">Password</span>
								 <input class="block w-full form-input{{ $errors->has('password') ? ' is-danger' : '' }}" type="password" name="password" value="" placeholder="Password" required>
							</label>

							@if ($errors->has('password'))
							<p>
								<strong>{{ $errors->first('password') }}</strong>
							</p>
							@endif
						</div>

						<div class="mt-4">
							<label class="block">
								<span class="block">Confirm Password</span>
								<input class="block w-full form-input" type="password" name="password_confirmation" value="" placeholder="Password" required>
							</label>

							@if ($errors->has('password_confirmation'))
							<p>
								<strong>{{ $errors->first('password_confirmation') }}</strong>
							</p>
							@endif
						</div>

						<div class="mt-8 text-center">
							<button class="btn btn-default" type="submit">Reset Password</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</section>
</div>
@endsection