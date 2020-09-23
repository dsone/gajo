@extends('layouts.main')

@section('content')
	@if (Route::has('login'))
		<div class="fixed top-0 right-0 hidden px-6 py-4 sm:block">
			@auth
				<a href="{{ route('user-profile', [ 'user' => Auth::user()->name ]) }}" class="text-sm text-gray-700 underline">Profile</a>
			@endif
		</div>
	@endif

	Options
@endsection
