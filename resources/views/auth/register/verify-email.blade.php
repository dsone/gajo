@extends('layouts.main')

@section('content')
<div class="register-form-container">
	@if (session('status') == 'verification-link-sent')
		<section>
			<div class="mb-4 font-medium text-sm text-green-600">
				Successfully registered!
			</div>
		</section>
	@endif

    <section class="section">
        <h1 class="title">Verify Mail</h1>
        <hr>
        <div class="columns">
            <div class="column">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf

                    <div class="field">
						@if (!session('status'))
                        	<label class="label">Register successful</label>
							<p class="control has-icons-left">
								Your registration was successful.<br>
								We send you a verification email with a confirmation link to activate your account.
							</p>
						@else
							<label class="label">Confirmation mail resend</label>
							<p class="control has-icons-left">
								We re-send you a verification email with a confirmation link to activate your registered account.
							</p>
						@endif                       
                    </div>

                    <div class="field">
                        <p class="control">
                            <button type="submit" class="button is-success">Resend confirmation</button>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection