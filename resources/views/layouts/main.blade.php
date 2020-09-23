<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
		<base href="{{ env('APP_URL') }}/" />
        <meta name="robots" content="index,follow">
        <meta name="revisit-after" content="7 days">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
        <link type="image/x-icon" href="./favicon.ico" rel="shortcut icon">
        <title>{{ config('app.name', '') }}@yield('title', '')</title>
		<link href="{{ mix('/css/app.css') }}" rel="stylesheet">
    </head>
    <body class="{{ \Auth::user() ? ' is-user' : ' is-visitor' }}">
		@include('layouts._navbar')

        <main>
			@yield('content')
        </main>

		@include('layouts._footer')

		<script src="{{ mix('/js/app.js') }}"></script>
        @yield('footerJS')
    </body>
</html>