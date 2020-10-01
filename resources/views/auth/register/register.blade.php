@extends('layouts.main')
@section('title', 'Register')

@section('content')
<div class="w-full px-4 pt-10 md:px-0 md:mx-auto md:w-1/3 lg:w-1/4">
    <section>
		<div class="p-10 bg-white rounded shadow-md">
			<div class="inline mx-auto">
				<h1 class="text-3xl font-bold">
					Register
				</h1>

				<div class="mt-4">
					<form method="POST" action="{{ route('register') }}">
						@csrf

						<div>
							<label class="block">
								<span class="block">Username</span>
								<input class="block w-full form-input{{ $errors->has('name') ? ' is-danger' : '' }}" name="name" type="text" placeholder="Username" value="{{ old('name') }}" required>
							</label>

							@if ($errors->has('name'))
							<p>
								<strong>{{ $errors->first('name') }}</strong>
							</p>
							@endif
						</div>

						<div class="mt-4">
							<label class="block">
								<span class="block">E-Mail Address</span>
								<input class="block w-full form-input{{ $errors->has('email') ? ' is-danger' : '' }}" name="email" type="text" placeholder="E-Mail Address" value="{{ old('email') }}" required>
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
								<input class="block w-full form-input{{ $errors->has('password_confirmation') ? ' is-danger' : '' }}" type="password" name="password_confirmation" value="" placeholder="Password" required>
							</label>

							@if ($errors->has('password_confirmation'))
							<p>
								<strong>{{ $errors->first('password_confirmation') }}</strong>
							</p>
							@endif
						</div>

						<div class="mt-8 text-center">
							<button class="btn btn-default" type="submit">Register</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</section>
</div>
@endsection