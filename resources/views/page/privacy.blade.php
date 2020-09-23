@extends('layouts.main')
@section('title', ' | Privacy')

@section('content')
<div class="w-full px-4 pt-20 md:px-0 md:mx-auto md:w-1/2">
	<section class="mt-20">
		<div class="p-10 bg-white rounded shadow-md">
			<h1 class="text-3xl font-bold">
				Gajo
			</h1>
			<div class="mt-4">
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
