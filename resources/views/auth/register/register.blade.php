@extends('layouts.main')

@section('content')
<div class="register-form-container">
    <section class="section">
        <h1 class="title">Register</h1>
        <hr>
        <div class="columns">
            <div class="column">
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="field">
                        <label class="label">Username</label>
                        <p class="control has-icons-left has-icons-right">
                            <input class="input{{ $errors->has('name') ? ' is-danger' : '' }}" name="name" type="text" placeholder="Username" value="{{ old('name') }}" required>
                        </p>
                        @if ($errors->has('name'))
                            <p class="help is-danger">
                                <strong>{{ $errors->first('name') }}</strong>
                            </p>
                        @endif
                    </div>

                    <div class="field">
                        <label class="label">E-Mail Address</label>
                        <p class="control has-icons-left has-icons-right">
                            <input class="input{{ $errors->has('email') ? ' is-danger' : '' }}" name="email" type="text" placeholder="E-Mail Address" value="{{ old('email') }}" required>
                        </p>
                        @if ($errors->has('email'))
                            <p class="help is-danger"><strong>{{ $errors->first('email') }}</strong></p>
                        @endif
                    </div>

                    <div class="field">
                        <label class="label">Password</label>
                        <p class="control has-icons-left">
                            <input class="input{{ $errors->has('password') ? ' is-danger' : '' }}" type="password" name="password" value="" placeholder="Password" required>
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
                            <input class="input{{ $errors->has('password_confirmation') ? ' is-danger' : '' }}" type="password" name="password_confirmation" value="" placeholder="Password" required>
                        </p>
                        @if ($errors->has('password_confirmation'))
                            <p class="help is-danger">
                                <strong>{{ $errors->first('password_confirmation') }}</strong>
                            </p>
                        @endif
                    </div>

                    <div class="field">
                        <p class="control">
                            <button type="submit" class="button is-success">Register</button>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection