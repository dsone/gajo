@extends('layouts.main')
@section('title', 'Options')

@section('content')
<div class="w-full px-4 pt-10 md:mx-auto lg:w-1/2">
	<form method="POST" action="{{ route('user-options-update', [ 'user' => $user->name ]) }}">
		
		@csrf
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
									<input type="checkbox" name="privateProfile" id="privateProfile" @if($options['privateProfile']) checked @endif>
									<label for="privateProfile" />
								</div>
								<label for="privateProfile">
									Enable private profile
								</label>
							</div>
							<div class="w-1/2 p-2 text-sm">
								If this is enabled, your profile is only visible to yourself when logged in, or via RSS links. Accessing your profile from outside will display a 404 page. Default: on.
							</div>
						</div>

						<div class="mt-8">
							<div>
								<div class="inline-block align-middle switch">
									<input type="checkbox" name="colorblind" id="colorblind" @if($options['colorblind']) checked @endif>
									<label for="colorblind" />
								</div>
								<label for="colorblind">
									Enable color blind mode
								</label>
							</div>
							<div class="w-1/2 p-2 text-sm">
								Gajo uses color to differentiate released, soon-to-be and future release entries. Enabling this will make it easier for you to distinguish those states if you are colorblind. Default: off.
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
								<div class="w-1/2">
									<input class="w-full form-input" type="text" name="rss" id="rss" value="{{ $options['rss'] }}">
								</div>
							</div>
							<div class="w-1/2 p-2 text-sm">
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
				<div class="inline mx-auto">
					<h1 class="text-3xl font-bold">
						List
					</h1>

					<div class="mt-4">
						<div>
							<div>
								<div class="inline-block align-middle switch">
									<input type="checkbox" name="hideReleased" id="hideReleased" @if($options['hideReleased']) checked @endif>
									<label for="hideReleased" />
								</div>
								<label for="hideReleased">
									Automatically hide released media
								</label>
							</div>
							<div class="w-1/2 p-2 text-sm">
								If this is enabled, releases that are in the past, are not displayed on your public list anymore. This helps keeping your list tidy. Default: yes.
							</div>
						</div>

						<div class="mt-8">
							<div>
								<div class="inline-block align-middle switch">
									<input type="checkbox" name="hideTBA" id="hideTBA" @if($options['hideTBA']) checked @endif>
									<label for="hideTBA" />
								</div>
								<label for="hideTBA">
									Automatically hide TBAs
								</label>
							</div>
							<div class="w-1/2 p-2 text-sm">
								If this is enabled, releases that have not yet a name and/or no release date are hidden from your public list. If you have many rumored releases, or those are pushed back multiple times already, you can use this to further tidy up your public list. Default: yes.
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>

		<div class="mt-8 text-center">
			<button class="btn btn-default" type="submit">Update</button>
		</div>

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

						@foreach($types as $type)
						<div class="flex flex-row mb-2">
							<span class="mr-1">
								<button class="h-full btn btn-default btn-icon">
									<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"></path></svg>
								</button>
							</span>

							<input class="form-input" name="name" value="{{ $type['name'] }}" type="text">
							<input class="form-input" name="ident_1" value="{{ $type['ident_1'] }}" type="text">
							<input class="form-input" name="ident_2" value="{{ $type['ident_2'] }}" type="text">

							<select class="form-select">
								<option value="1" @if($type['display'] == 1) selected="selected" @endif>List Display</option>
								<option value="2" @if($type['display'] == 2) selected="selected" @endif>Card Display</option>
							</select>

							<form action="{{ route('user-type-destroy', [ 'user' => $user->name, 'type' => $type->id ]) }}" method="POST">
								@csrf
								<input type="hidden" name="_method" value="delete">

								<button class="ml-1 btn btn-danger btn-icon" type="submit">
									<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
								</button>
							</form>
						</div>
						@endforeach
					</div>
					<div class="js-types-empty italic @if(count($types) > 0) hidden @endif">
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
	</form>
</div>

<template id="type-item">
</template>

<template id="modal-type">
	<div>
		<h2 class="mb-4 text-xl font-bold">Add a new type</h2>
		<div class="w-full">
			<form method="POST" action="{{ route('user-type-store', [ 'user' => $user->name ]) }}">
				@csrf

				<div>
					<label class="block">
						<span class="block mb-1 font-bold">Name</span>
						<input class="block w-full form-input{{ $errors->has('name') ? ' is-danger' : '' }}" name="name" type="text" placeholder="Name" value="{{ old('name') }}" required>
					</label>

					<span class="block mt-1 text-sm">
						The name for your Type. Will be displayed as a header.
					</span>

					@if ($errors->has('name'))
					<p>
						<strong>{{ $errors->first('name') }}</strong>
					</p>
					@endif
				</div>
				<div class="mt-4">
					<label class="block">
						<span class="block mb-1 font-bold">Descriptor 1</span>
						<input class="block w-full form-input" name="ident_1" type="text" value="" placeholder="Descriptor 1" required>
					</label>

					<span class="block mt-1 text-sm">
						A further describing attribute, ie. the Artist for a CD, or the Author for book or similar.
					</span>

					@if ($errors->has('ident_1'))
					<p class="help is-danger">
						<strong>{{ $errors->first('ident_1') }}</strong>
					</p>
					@endif
				</div>

				<div class="mt-4">
					<label class="block">
						<span class="block mb-1 font-bold">Descriptor 2</span>
						<input class="block w-full form-input" name="ident_2" type="text" value="" placeholder="Descriptor 2" required>
					</label>

					<span class="block mt-1 text-sm">
						The second attribute, usually the tile or name, like of a record, or of a book.
					</span>

					@if ($errors->has('ident_2'))
					<p class="help is-danger">
						<strong>{{ $errors->first('ident_2') }}</strong>
					</p>
					@endif
				</div>

				<div class="mt-4">
					<label class="block">
						<span class="block mb-1 font-bold">Display Style</span>
						<select class="w-full form-select" name="display">
							<option selected="selected" value="1">List Display</option>
							<option value="2">Card Display</option>
						</select>
					</label>
					<span class="block mt-1 text-sm">
						How should this type be displayed? List is default, but Card if for the occasions where you want something fancy.
					</span>

					@if ($errors->has('display'))
					<p class="help is-danger">
						<strong>{{ $errors->first('display') }}</strong>
					</p>
					@endif
				</div>

				<div class="flex flex-row justify-between mt-8">
					<button class="btn btn-success btn-icon" type="submit">
						<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Save
					</button>

					<button class="btn btn-default btn-icon js-modal-close" type="button">
						<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> Cancel
					</button>
				</div>
			</form>
		</div>
	</div>
</template>

<script async="false">
	(function() {
		setTimeout(function() {
			var typeModal = new Modal(document.querySelector('template#modal-type').innerHTML);
			var btnCloseModal = typeModal.element.querySelector('.js-modal-close');
			if (btnCloseModal) {
				var typeModalForm = typeModal.element.querySelector('form');
				btnCloseModal.addEventListener('click', function(e) {
					typeModal.hide();

					if (typeModalForm) {
						typeModalForm.reset();
					}
				});
			}

			var btnAddType = document.querySelector('.js-modal-add-type');
			if (btnAddType) {
				btnAddType.addEventListener('click', function() {
					typeModal.show();
				});
			}
		}, 1000);
	})();
</script>


@endsection