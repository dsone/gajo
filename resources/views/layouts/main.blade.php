<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta name="robots" content="index,follow">
        <meta name="revisit-after" content="7 days">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <base href="{{ env('APP_URL') }}/" />
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="Content-Language" content="{{ app()->getLocale() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="keywords" content="">
        <meta name="description" content="">
        <link type="image/x-icon" href="./favicon.ico" rel="shortcut icon">
        <title>@yield('title', config('app.name', ''))</title>
    </head>
    <body class="has-navbar-fixed-top{{ \Auth::user() ? ' is-user' : ' is-visitor' }}">
        <div class="main-container">
            <div class="main-content">
                @yield('content')
            </div>
        </div>

        @yield('footerJS')
    </body>
</html>