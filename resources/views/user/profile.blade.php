@extends('layouts.main')
@section('title', 'Profile - ' . $user->name)

@section('content')
	<div class="section-container"></div>

	@include('templates.profile-cards')
	@include('templates.profile-tables')
	@include('templates.modal-entry-confirm')
	@include('templates.modal-entry-add')
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
