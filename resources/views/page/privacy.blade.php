@extends('index')
@section('title', config('app.name', '') . ' - Privacy')

@section('content')
<div class="container">
    <section class="hero">
        <div class="hero-body">
            <div class="container">
                <h1 class="title">Privacy</h1>
                <p>
                    This website does not use any form of tracking.<br>
                    No cookies for tracking are used, but this website sets a so-called XSRF-TOKEN and a session cookie, these are necessary functional cookies and save no personal data.
                </p>
                <p>The server saves only anonymized IPs and rotates every week and deletes logs after 4 weeks.</p>
                <p>This website uses SSL encryption and certificates from Let's Encrypt. Meaning every connection to this website is secure.</p>
            </div>
        </div>
    </section>
</div>
@endsection