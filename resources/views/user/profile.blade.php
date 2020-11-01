@extends('layouts.main')
@section('title', 'Profile - ' . $user->name)

@section('content')
	<div class="section-container">
		@if($ownProfile)
		<div class="hidden w-1/2 p-10 mx-auto text-center duration-200 bg-white shadow-md hover:shadow-sm" bind-start>
			<div class="font-bold">
				You have no entries added yet.
			</div>
			@if (count($types) == 0)
			<div class="mt-2">
				Add a Type in <a class="font-semibold tracking-wide underline" href="{{ route('user-options', [ 'user' => $user->name ]) }}">Options</a> first.
			</div>
			<div class="mt-2">
				Then start adding your entries here!
			</div>
			@else
			<div class="mt-2">
				<button class="btn btn-default" onclick="document.querySelector('.js-navbar-add-entry').click()">Add Entry</button>
			</div>
			@endif
		</div>
		@else
		<div class="w-1/2 p-10 mx-auto duration-200 bg-white shadow-md hover:shadow-sm">
			This user has no entries yet!
		</div>
		@endif
	</div>

	@include('templates.profile-cards')
	@include('templates.profile-tables')
	@include('templates.modal-entry-confirm')
	@include('templates.modal-entry-add')
	@include('templates.modal-entry-edit')
@endsection

@section('footerJS')
	<script>
		var __ROUTES = {
			entries: {
				store: '{{ route('api-entry-store') }}',
				update: '{{ route('api-entry-update') }}',
				remove: '{{ route('api-entry-destroy') }}',
			}
		};
		var __EDITMODE = {{ $ownProfile }};
		var __TYPES = @json($types);
    </script>
	<script src="{{ mix('/js/profile.js') }}"></script>
@endsection
