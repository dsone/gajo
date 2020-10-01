@extends('layouts.main')
@section('title', 'Profile')

@section('content')
	@if (Route::has('login'))
		<div class="fixed top-0 right-0 hidden px-6 py-4 sm:block">
			@auth
				<a href="{{ route('user-options', [ 'user' => Auth::user()->name ]) }}" class="text-sm text-gray-700 underline">Options</a>
			@endif
		</div>
	@endif

	Profile
@endsection
