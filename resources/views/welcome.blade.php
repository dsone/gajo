@extends('layouts.main')

@section('content')
<div class="relative flex justify-center min-h-screen bg-gray-100 items-top dark:bg-gray-900 sm:items-center sm:pt-0">
	@if (Route::has('login'))
		<div class="fixed top-0 right-0 hidden px-6 py-4 sm:block">
			@auth
				<a href="{{ route('user-profile', [ 'user' => Auth::user()->name ]) }}" class="text-sm text-gray-700 underline">Profile</a>
			@else
				<a href="{{ route('login') }}" class="text-sm text-gray-700 underline">Login</a>

				@if (Route::has('register'))
					<a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 underline">Register</a>
				@endif
			@endif
		</div>
	@endif

	<div class="container">
		<section class="hero">
			<div class="hero-body">
				<div class="container">
					<h1 class="title">Gajo</h1>
					<h2 class="subtitle">
						A release list ...list
					</h2>
					<p>
						Imagine a shopping list but not for groceries but releases near or far into the future.<br>
						What kind of releases? Your choice! Books, CDs, DVDs, Games, Concerts, whatever you need help remembering with!
					</p>
					<br>
					<p>
						Have you ever wished there would be an easier way to keep track of what CDs, DVDs, books etc. are set for a near future release?
					</p>
					<p>
						Have you ever forgot your favourite band were releasing a new EP or CD and got caught off guard weeks after the initial release?
					</p>
					<p>Put an end to that with Gajo!</p>
					<?php
						if (registerable()) {
							echo "<br><br><p><a class=\"button is-primary\" href=\"./register\">Register now</a></p>";
						}
					?>
				</div>
			</div>
		</section>
	</div>
</div>
@endsection
