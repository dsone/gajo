@extends('index')

@section('content')
<div class="login-form-container">
    <section class="section">
    <h1 class="title">Login</h1>
    <hr>
    <div class="columns">
        <div class="column">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="field">
                    <label class="label">Username</label>
                    <p class="control has-icons-left has-icons-right">
                        <input class="input {{ $errors->has('name') ? ' is-danger' : '' }}" name="name" type="text" placeholder="Username" value="{{ old('username') }}" required>
                        <span class="icon is-small is-left">@svg('solid/user-circle')</span>
                    </p>
                    @if ($errors->has('name'))
                        <p class="help is-danger">
                            <strong>{{ $errors->first('name') }}</strong>
                        </p>
                    @endif
                </div>
                <div class="field">
                    <label class="label">Password</label>
                    <p class="control has-icons-left">
                        <input class="input is-success" name="password" type="password" value="" placeholder="Password" required>
                        <span class="icon is-small is-left">@svg('solid/key')</span>
                        @if ($errors->has('password'))
                            <p class="help is-danger">
                                <strong>{{ $errors->first('password') }}</strong>
                            </p>
                        @endif
                    </p>
                </div>

                <div class="field">
                    <label>
                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                    </label>
                </div>

                <div class="field">
                    <p class="control">
                        <button type="submit" class="button is-primary">@svg('solid/sign-in-alt')&nbsp;Login</button>
                    </p>
                </div>
                <div class="field">
                    <p class="control">
                        <a class="" href="{{ route('password.request') }}">Forgot Your Password?</a>
                    </p>
                </div>
            </form>
        </div>
    </section>
</div>
@endsection