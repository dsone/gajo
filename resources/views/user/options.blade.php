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

<template id="type-item">
	<div class="draggable-item" data-id="#type_id#">
		<div class="flex flex-row justify-center">
			<div class="flex items-center mr-2 md:mr-1 justify-items-center">
				<button draggable="true" class="btn btn-default btn-icon draggable js-btn-drag" type="button">
					<svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 pb-1" viewBox="0 0 20 20" fill="currentColor">
						<path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
					</svg>
				</button>
			</div>

			<div class="flex flex-col w-3/4">
				<div class="block md:flex md:flex-row">
					<input class="w-full md:w-1/2 form-input js-type-name" name="name" value="#type_name#" type="text" placeholder="Name">

					<select class="w-full mt-1 md:w-1/2 md:ml-1 form-select md:mt-0 js-type-select" name="display">
						<option value="1">List Display</option>
						<option value="2">Card Display</option>
					</select>
				</div>

				<div class="block mt-1 md:flex md:flex-row">
					<input class="w-full md:w-1/2 form-input js-type-ident1" name="ident_1" value="#type_ident1#" type="text" placeholder="Descriptor 1">
					<input class="w-full mt-1 md:w-1/2 md:ml-1 form-input md:mt-0 js-type-ident2" name="ident_2" value="#type_ident2#" type="text" placeholder="Descriptor 2">
				</div>
			</div>

			<div class="flex items-center ml-2 justify-items-center md:ml-1">
				<button class="btn btn-danger btn-icon js-remove-type" type="text" data-index="#type_index#">
					<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
				</button>
			</div>
		</div>

		<div class="h-6 drag-target" data-target="#type_index#">
			&nbsp;
		</div>
	</div>
</template>

<template id="modal-type">
	<div>
		<h2 class="mb-4 text-xl font-bold">Add a new type</h2>
		<div class="w-full">
			<form method="POST" action="/">
				<div>
					<label class="block">
						<span class="block mb-1 font-bold">Name</span>
						<input class="block w-full form-input" name="name" type="text" placeholder="Name" value="{{ old('name') }}" required>
					</label>

					<span class="block mt-1 text-sm">
						The name for your Type. Will be displayed as a header.
					</span>
				</div>
				<div class="mt-4">
					<label class="block">
						<span class="block mb-1 font-bold">Descriptor 1</span>
						<input class="block w-full form-input" name="ident_1" type="text" value="" placeholder="Descriptor 1" required>
					</label>

					<span class="block mt-1 text-sm">
						A further describing attribute, ie. the Artist for a CD, or the Author for book or similar.
					</span>
				</div>

				<div class="mt-4">
					<label class="block">
						<span class="block mb-1 font-bold">Descriptor 2</span>
						<input class="block w-full form-input" name="ident_2" type="text" value="" placeholder="Descriptor 2" required>
					</label>

					<span class="block mt-1 text-sm">
						The second attribute, usually the tile or name, like of a record, or of a book.
					</span>
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
				</div>

				<div class="flex flex-row justify-between mt-8">
					<button class="btn btn-success btn-icon js-save-type" type="button">
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
<template id="modal-remove-confirm">
	<div>
		<h2 class="mb-4 text-xl font-bold text-center">Do you want to remove this type?</h2>
		<div class="w-full">
			<div class="mt-4 text-xl">
				<div class="text-center" bind-name></div>
				<div class="flex flex-row justify-center">
					<div bind-ident1></div>
					<span class="mx-2">-</span>
					<div bind-ident2></div>
				</div>
			</div>
			
			<div class="mt-4 text-center">
				<p>Do you really want to delete this Type?</p>
				All remaining Entries attached to this type will lose their Type.
			</div>

			<div class="flex flex-row justify-between mt-8">
				<button class="btn btn-success btn-icon js-modal-confirm" type="button" bind-type-id>
					<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Remove
				</button>

				<button class="btn btn-default btn-icon js-modal-close" type="button">
					<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> Cancel
				</button>
			</div>
		</div>
	</div>
</template>
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