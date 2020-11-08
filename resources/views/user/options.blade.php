@extends('layouts.main')
@section('title', 'Options')

@section('content')
<div class="w-full px-4 pt-10 md:mx-auto lg:w-1/2">
	<section>
		<div class="p-10 bg-white rounded shadow-md">
			<div class="inline mx-auto">
				<h1 class="text-3xl font-bold">
					Profile
				</h1>

				<div class="mt-4">
					<div>
						<div>
							<div class="inline-block align-middle switch">
								<input type="checkbox" class="js-options-privateProfile" name="privateProfile" id="privateProfile" @if($options['privateProfile']) checked @endif>
								<label for="privateProfile" />
							</div>
							<label for="privateProfile">
								Enable private profile
							</label>
						</div>
						<div class="w-2/3 p-2 text-sm">
							If this is enabled, your profile is only visible to yourself when logged in, or via RSS links. Accessing your profile from outside will display a 404 page. <span class="whitespace-no-wrap">Default: on</span>.
						</div>
					</div>

					<div class="mt-8">
						<div>
							<div class="inline-block align-middle switch">
								<input type="checkbox" class="js-options-colorblind" name="colorblind" id="colorblind" @if($options['colorblind']) checked @endif>
								<label for="colorblind" />
							</div>
							<label for="colorblind">
								Enable color blind mode
							</label>
						</div>
						<div class="w-2/3 p-2 text-sm">
							Gajo uses color to differentiate released, soon-to-be and future release entries. Enabling this will make it easier for you to distinguish those states if you are colorblind. <span class="whitespace-no-wrap">Default: off</span>.
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="mt-4">
		<div class="p-10 bg-white rounded shadow-md">
			<div class="inline mx-auto">
				<h1 class="text-3xl font-bold">
					List
				</h1>

				<div class="mt-4">
					<div>
						<div>
							<div class="inline-block align-middle switch">
								<input type="checkbox" class="js-options-hideReleased" name="hideReleased" id="hideReleased" @if($options['hideReleased']) checked @endif>
								<label for="hideReleased" />
							</div>
							<label for="hideReleased">
								Automatically hide released media
							</label>
						</div>
						<div class="w-2/3 p-2 text-sm">
							If this is enabled, releases that are in the past, are not displayed on your public list anymore. This helps keeping your list tidy. <span class="whitespace-no-wrap">Default: yes</span>.
						</div>
					</div>

					<div class="mt-8">
						<div>
							<div class="inline-block align-middle switch">
								<input type="checkbox" class="js-options-hideTBA" name="hideTBA" id="hideTBA" @if($options['hideTBA']) checked @endif>
								<label for="hideTBA" />
							</div>
							<label for="hideTBA">
								Automatically hide TBAs
							</label>
						</div>
						<div class="w-2/3 p-2 text-sm">
							If this is enabled, releases that have not yet a name and/or no release date are hidden from your public list. If you have many rumored releases, or those are pushed back multiple times already, you can use this to further tidy up your public list. <span class="whitespace-no-wrap">Default: yes</span>.
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="mt-4">
		<div class="p-10 bg-white rounded shadow-md">
			<div class="inline mx-auto">
				<h1 class="text-3xl font-bold">
					RSS
				</h1>

				<div class="mt-4">
					<div>
						<div>
							<div class="flex flex-row w-2/3">
								<input class="flex-grow mr-1 form-input js-options-rss" type="text" name="rss" id="rss" value="{{ $options['rss'] }}" readonly>

								<button class="btn btn-default js-btn-rss" type="button" data-uri="{{ route('api-refresh-rss') }}">
									<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
								</button>
							</div>
						</div>
						<div class="w-2/3 p-2 text-sm">
							<label for="rss">
								This is your RSS link for your list. Each user has a unique id to use. You can change your ID as often as you want. Remember to update your RSS feed reader to use the new ID.
							</label>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="mt-4">
		<div class="p-10 bg-white rounded shadow-md">
			<div>
				<h1 class="text-3xl font-bold">
					Types
				</h1>

				<div class="mt-4">
					Types are the groups for your list. You could also call these categories, or groups. One type can be a CD for example, or a Book. Whereas each Type has its own two "identifications", making entries distinguishable from each other. A book has an author and a title for example, while a CD has usually an artist and a record name.
					You can add as many types as you want with whatever identifications you want to use. You define the Type aka category and label your identifications.
				</div>
			</div>
		
			<div class="mt-6">
				<h3 class="mb-2 text-lg font-bold">Available Types</h3>
				<div class="js-types-container">
					{{-- Filled in JavaScript at runtime --}}
				</div>
				<div class="hidden italic js-types-empty">
					You have no types, start adding some!
				</div>

				<div class="h-8 mt-8">
					<button class="float-right btn btn-success btn-icon js-modal-add-type" type="button">
						<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> Add
					</button>
				</div>
			</div>
		</div>
	</section>
</div>

@include('templates.options.type-item')
@include('templates.options.modal-type')
@include('templates.options.modal-type-confirm')
@endsection

@section('footerJS')
	<script>
		var __ROUTES = {
			options: '{{ route('user-options-update', [ 'user' => $user->name ]) }}',
			types: {
				store: '{{ route('api-type-store') }}',
				order: '{{ route('api-type-order') }}',
				update: '{{ route('api-type-update') }}',
				remove: '{{ route('api-type-destroy') }}',
			}
		};
		var __TYPES = @json($types);
	</script>
	<script src="{{ mix('/js/options.js') }}"></script>
@endsection