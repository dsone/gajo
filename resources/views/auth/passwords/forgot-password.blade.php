@extends('layouts.main')
@section('title', 'Forgot Password')

@section('content')
<div class="w-full px-4 pt-10 md:px-0 md:mx-auto md:w-1/3 lg:w-1/4">
	@if (session('status'))
	<section class="mb-8">
		<div class="p-4 text-center bg-green-300 rounded shadow-md">
			<div class="font-medium text-md">
				{{ session('status') }}
			</div>
		</div>
	</section>
	@endif

    <section>
		<div class="p-10 bg-white rounded shadow-md">
			<div class="inline mx-auto">
				<h1 class="text-3xl font-bold">
					Reset Password
				</h1>

				<div class="mt-4">
					<form method="POST" action="{{ route('password.email') }}">
						@csrf

						<div>
							<label class="block">
								<span class="block mb-1 font-bold">E-Mail Address</span>
								<input class="block w-full form-input{{ $errors->has('email') ? ' is-danger' : '' }}" type="text" placeholder="E-Mail Address" value="{{ $email ?? old('email') }}" name="email" required>
							</label>

							@if ($errors->has('email'))
							<p>
								<strong>{{ $errors->first('email') }}</strong>
							</p>
							@endif
						</div>

						<div class="mt-8 text-center">
							<button class="pb-2 btn btn-default" type="submit">Send Password Reset Link</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</section>
</div>
@endsection
