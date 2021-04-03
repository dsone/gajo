@extends('layouts.main')
@section('meta_index', 'noindex,nofollow')
@section('title', '404 - Not Found')

@section('content')
<div class="w-full xl:w-2/3 xl:mx-auto">
	<div class="w-full px-4 pt-10 md:px-0 md:mx-auto md:w-1/2">
		<section>
			<div class="p-10 bg-white rounded shadow-md">
				<h1 class="text-3xl font-bold">
					404 
					<small class="text-md">
						
					</small>
				</h1>
				<h2 class="text-xl">
					Not Found
				</h2>
				<div class="mt-4 text-md">
					<p>
						The page you were looking for does not exist.
					</p>
					@auth
						<p class="mt-4 text-lg">Go to your <a class="font-semibold underline" href="{{ route('user-profile', [ 'user' => Auth::user()->name ]) }}">profile</a>.</p>
					@else
						<p class="mt-4 text-lg">Go back <a class="font-semibold underline" href="/">home</a>.</p>
					@endauth
				</div>
			</div>
		</section>
	</div>
</div>
@endsection