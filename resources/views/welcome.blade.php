@extends('layouts.main')
@section('title', 'Welcome')

@section('content')
<div class="w-full px-4 pt-10 md:px-0 md:mx-auto md:w-1/2">
	<section>
		<div class="p-10 bg-white rounded shadow-md">
			<h1 class="text-3xl font-bold">
				Gajo
			</h1>
			<h2 class="text-xl">
				A release list ...list
			</h2>
			<div class="mt-4">
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
				@registerable
					<p class="pt-10">
						<a class="pb-2 btn btn-default" href="./register">Register now</a>
					</p>
				@endregisterable
			</div>
		</div>
	</section>
</div>
@endsection
