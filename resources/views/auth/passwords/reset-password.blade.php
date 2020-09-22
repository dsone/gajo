@extends('layouts.main')

@section('content')
<div class="reset-form-container">
    <section class="section">
    <h1 class="title">Reset Password</h1>
    <hr>
    <div class="columns">
        <div class="column">
            <form method="POST" action="{{ route('password.update') }}">
                @csrf

				<input type="hidden" name="token" value="{{ $request->route('token') }}">

                <div class="field">
                    <label class="label">E-Mail Address</label>
                    <p class="control has-icons-left">
                        <input class="input {{ $errors->has('email') ? ' is-danger' : '' }}" type="text" placeholder="E-Mail Address" value="{{ $request->email ?? old('email') }}" name="email" required>
                    </p>
                    @if ($errors->has('email'))
                        <p class="help is-danger"><strong>{{ $errors->first('email') }}</strong></p>
                    @endif
                </div>

                <div class="field">
                    <label class="label">Password</label>
                    <p class="control has-icons-left">
                        <input class="input {{ $errors->has('password') ? ' is-danger' : '' }}" type="password" name="password" value="" placeholder="Password" required>
                        @if ($errors->has('password'))
                            <p class="help is-danger">
                                <strong>{{ $errors->first('password') }}</strong>
                            </p>
                        @endif
                    </p>
                </div>

                <div class="field">
                    <label class="label">Confirm Password</label>
                    <p class="control has-icons-left">
                        <input class="input" type="password" name="password_confirmation" value="" placeholder="Password" required>
                    </p>
                    @if ($errors->has('password_confirmation'))
                        <p class="help is-danger">
                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                        </p>
                    @endif
                </div>

                <div class="field">
                    <p class="control">
                        <button type="submit" class="button is-primary">Reset Password</button>
                    </p>
                </div>
            </form>
        </div>
    </section>
</div>
@endsection