@extends('layouts.main')

@section('content')
<div class="login-form-container">
    <section class="section">
    <h1 class="title">Login</h1>
    <hr>
    <div>
        <div>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div>
                    <label>Username</label>
                    <p>
                        <input class="input {{ $errors->has('email') ? ' is-danger' : '' }}" name="email" type="text" placeholder="Username" value="{{ old('email') }}" required>
                    </p>
                    @if ($errors->has('name'))
                        <p>
                            <strong>{{ $errors->first('name') }}</strong>
                        </p>
                    @endif
                </div>
                <div>
                    <label>Password</label>
                    <p>
                        <input name="password" type="password" value="" placeholder="Password" required>
                        @if ($errors->has('password'))
                            <p class="help is-danger">
                                <strong>{{ $errors->first('password') }}</strong>
                            </p>
                        @endif
                    </p>
                </div>

                <div>
                    <label>
                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                    </label>
                </div>

                <div>
                    <p>
                        <button type="submit">Login</button>
                    </p>
                </div>
                <div>
                    <p>
                        <a href="{{ route('password.request') }}">Forgot Your Password?</a>
                    </p>
                </div>
            </form>
        </div>
    </section>
</div>
@endsection