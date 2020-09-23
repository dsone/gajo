@extends('layouts.main')

@section('content')
<div class="w-full px-4 pt-10 md:px-0 md:mx-auto md:w-1/3 lg:w-1/4">
	@if (session('status') == 'verification-link-sent')
	<section class="mb-8">
		<div class="p-4 text-center bg-green-300 rounded shadow-md">
			<div class="font-medium text-md">
				Successfully registered!
			</div>
		</div>
	</section>
	@endif

	<section class="mb-8">
		<div class="p-4 text-center bg-green-300 rounded shadow-md">
			<div class="font-medium text-md">
				Account registration successful!
			</div>
		</div>
	</section>

    <section>
		<div class="p-10 bg-white rounded shadow-md">
			<div class="inline mx-auto">
				<h1 class="text-3xl font-bold">
					Verify Your E-Mail
				</h1>

				<div class="mt-4">
					<form method="POST" action="{{ route('verification.send') }}">
						@csrf

						<div>
							@if (!session('status'))
                        		<span class="block">
									We've sent you a verification email with a confirmation link to activate your account.
								</span>								
							@else
								<span class="block">Confirmation mail re-sent</span>
								<span class="block">
									We've re-sent you a verification email with a confirmation link to activate your account.
								</span>
							@endif
						</div>

						<div class="mt-8 text-center">
							<button class="btn btn-default" type="submit">Resend confirmation link</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</section>
</div>
@endsection