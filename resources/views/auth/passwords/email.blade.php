@extends('index')

@section('content')
<div class="reset-form-container">
    <section class="section">
    <h1 class="title">Reset Password</h1>
    <hr>
    <div class="columns">
        <div class="column">
            @if (session('status'))
                <div class="notification is-danger">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="field">
                    <label class="label">E-Mail Address</label>
                    <p class="control has-icons-left">
                        <input class="input {{ $errors->has('email') ? ' is-danger' : '' }}" type="text" placeholder="E-Mail Address" value="{{ $email or old('email') }}" required>
                        <span class="icon is-small is-left">@svg('solid/envelope')</span>
                    </p>
                    @if ($errors->has('email'))
                        <p class="help is-danger"><strong>{{ $errors->first('email') }}</strong></p>
                    @endif
                </div>

                <div class="field">
                    <p class="control">
                        <button type="submit" class="button is-primary">Send Password Reset Link</button>
                    </p>
                </div>
            </form>
        </div>
    </section>
</div>
@endsection
