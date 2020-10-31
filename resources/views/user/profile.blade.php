@extends('layouts.main')
@section('title', 'Profile')

@section('content')
	<template id="skeleton-table-section">
		<div class="w-full mt-10 md:mx-auto md:w-2/3 lg:w-1/2">
			<section class="section-table-entries">
				<h3 class="section-title" bind-section-title></h3>

				<div class="" bind-table>
					{{-- #table-skeleton --}}
				</div>
			</section>
		</div>
	</template>
	<template id="skeleton-table">
		<ul class="table-entries">
			<li class="table-headline">
				<div class="flex flex-row">
					<div class="w-4/12" bind-ident1></div>
					<div class="w-4/12" bind-ident2></div>
					<div class="w-2/12">Release</div>
					<div class="w-2/12">&nbsp;</div>
				</div>
			</li>
			{{-- #table-list-entry --}}
		</ul>
	</template>
	<template id="skeleton-table-entry">
		<li class="table-entry">
			<div class="flex flex-row">
				<div class="w-4/12" bind-ident1></div>
				<div class="w-4/12" bind-ident2></div>
				<div class="w-3/12" bind-release></div>
				<div class="flex flex-row justify-end w-1/12">
					<svg class="mr-2 transition-opacity duration-150 opacity-0 svg-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path d="M402.3 344.9l32-32c5-5 13.7-1.5 13.7 5.7V464c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V112c0-26.5 21.5-48 48-48h273.5c7.1 0 10.7 8.6 5.7 13.7l-32 32c-1.5 1.5-3.5 2.3-5.7 2.3H48v352h352V350.5c0-2.1.8-4.1 2.3-5.6zm156.6-201.8L296.3 405.7l-90.4 10c-26.2 2.9-48.5-19.2-45.6-45.6l10-90.4L432.9 17.1c22.9-22.9 59.9-22.9 82.7 0l43.2 43.2c22.9 22.9 22.9 60 .1 82.8zM460.1 174L402 115.9 216.2 301.8l-7.3 65.3 65.3-7.3L460.1 174zm64.8-79.7l-43.2-43.2c-4.1-4.1-10.8-4.1-14.8 0L436 82l58.1 58.1 30.9-30.9c4-4.2 4-10.8-.1-14.9z"></path></svg>

					<svg class="transition-opacity duration-150 opacity-0 svg-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M192 188v216c0 6.627-5.373 12-12 12h-24c-6.627 0-12-5.373-12-12V188c0-6.627 5.373-12 12-12h24c6.627 0 12 5.373 12 12zm100-12h-24c-6.627 0-12 5.373-12 12v216c0 6.627 5.373 12 12 12h24c6.627 0 12-5.373 12-12V188c0-6.627-5.373-12-12-12zm132-96c13.255 0 24 10.745 24 24v12c0 6.627-5.373 12-12 12h-20v336c0 26.51-21.49 48-48 48H80c-26.51 0-48-21.49-48-48V128H12c-6.627 0-12-5.373-12-12v-12c0-13.255 10.745-24 24-24h74.411l34.018-56.696A48 48 0 0 1 173.589 0h100.823a48 48 0 0 1 41.16 23.304L349.589 80H424zm-269.611 0h139.223L276.16 50.913A6 6 0 0 0 271.015 48h-94.028a6 6 0 0 0-5.145 2.913L154.389 80zM368 128H80v330a6 6 0 0 0 6 6h276a6 6 0 0 0 6-6V128z"></path></svg>
				</div>
			</div>
		</li>
	</template>

	<div class="section-container">
		{{--
		<div class="w-full mt-10 md:mx-auto md:w-2/3 lg:w-1/2">
			<section class="section-table-entries">
				<h3 class="section-title">CDs</h3>

				<div class="">
					<ul class="table-entries">
						<li class="table-headline">
							<div class="flex flex-row">
								<div class="w-4/12">Artist</div>
								<div class="w-4/12">Album</div>
								<div class="w-2/12">Release</div>
								<div class="w-2/12">&nbsp;</div>
							</div>
						</li>
						<li class="table-entry">
							<div class="flex flex-row">
								<div class="w-4/12">All That Remains</div>
								<div class="w-4/12">TBA</div>
								<div class="w-3/12">Wed, 31 Mar 2021</div>
								<div class="flex flex-row justify-end w-1/12">
									<svg class="mr-2 transition-opacity duration-150 opacity-0 svg-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path d="M402.3 344.9l32-32c5-5 13.7-1.5 13.7 5.7V464c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V112c0-26.5 21.5-48 48-48h273.5c7.1 0 10.7 8.6 5.7 13.7l-32 32c-1.5 1.5-3.5 2.3-5.7 2.3H48v352h352V350.5c0-2.1.8-4.1 2.3-5.6zm156.6-201.8L296.3 405.7l-90.4 10c-26.2 2.9-48.5-19.2-45.6-45.6l10-90.4L432.9 17.1c22.9-22.9 59.9-22.9 82.7 0l43.2 43.2c22.9 22.9 22.9 60 .1 82.8zM460.1 174L402 115.9 216.2 301.8l-7.3 65.3 65.3-7.3L460.1 174zm64.8-79.7l-43.2-43.2c-4.1-4.1-10.8-4.1-14.8 0L436 82l58.1 58.1 30.9-30.9c4-4.2 4-10.8-.1-14.9z"></path></svg>

									<svg class="transition-opacity duration-150 opacity-0 svg-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M192 188v216c0 6.627-5.373 12-12 12h-24c-6.627 0-12-5.373-12-12V188c0-6.627 5.373-12 12-12h24c6.627 0 12 5.373 12 12zm100-12h-24c-6.627 0-12 5.373-12 12v216c0 6.627 5.373 12 12 12h24c6.627 0 12-5.373 12-12V188c0-6.627-5.373-12-12-12zm132-96c13.255 0 24 10.745 24 24v12c0 6.627-5.373 12-12 12h-20v336c0 26.51-21.49 48-48 48H80c-26.51 0-48-21.49-48-48V128H12c-6.627 0-12-5.373-12-12v-12c0-13.255 10.745-24 24-24h74.411l34.018-56.696A48 48 0 0 1 173.589 0h100.823a48 48 0 0 1 41.16 23.304L349.589 80H424zm-269.611 0h139.223L276.16 50.913A6 6 0 0 0 271.015 48h-94.028a6 6 0 0 0-5.145 2.913L154.389 80zM368 128H80v330a6 6 0 0 0 6 6h276a6 6 0 0 0 6-6V128z"></path></svg>
								</div>
							</div>
						</li>
						<li class="table-entry">
							<div class="flex flex-row">
								<div class="w-4/12">Scar Symmetry</div>
								<div class="w-4/12">The Singularity (Phase II: Xenotaph)</div>
								<div class="w-3/12">TBA</div>
								<div class="flex flex-row justify-end w-1/12">
									<svg class="mr-2 transition-opacity duration-150 opacity-0 svg-icon group-hover:opacity-100" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path d="M402.3 344.9l32-32c5-5 13.7-1.5 13.7 5.7V464c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V112c0-26.5 21.5-48 48-48h273.5c7.1 0 10.7 8.6 5.7 13.7l-32 32c-1.5 1.5-3.5 2.3-5.7 2.3H48v352h352V350.5c0-2.1.8-4.1 2.3-5.6zm156.6-201.8L296.3 405.7l-90.4 10c-26.2 2.9-48.5-19.2-45.6-45.6l10-90.4L432.9 17.1c22.9-22.9 59.9-22.9 82.7 0l43.2 43.2c22.9 22.9 22.9 60 .1 82.8zM460.1 174L402 115.9 216.2 301.8l-7.3 65.3 65.3-7.3L460.1 174zm64.8-79.7l-43.2-43.2c-4.1-4.1-10.8-4.1-14.8 0L436 82l58.1 58.1 30.9-30.9c4-4.2 4-10.8-.1-14.9z"></path></svg>

									<svg class="transition-opacity duration-150 opacity-0 svg-icon group-hover:opacity-100" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M192 188v216c0 6.627-5.373 12-12 12h-24c-6.627 0-12-5.373-12-12V188c0-6.627 5.373-12 12-12h24c6.627 0 12 5.373 12 12zm100-12h-24c-6.627 0-12 5.373-12 12v216c0 6.627 5.373 12 12 12h24c6.627 0 12-5.373 12-12V188c0-6.627-5.373-12-12-12zm132-96c13.255 0 24 10.745 24 24v12c0 6.627-5.373 12-12 12h-20v336c0 26.51-21.49 48-48 48H80c-26.51 0-48-21.49-48-48V128H12c-6.627 0-12-5.373-12-12v-12c0-13.255 10.745-24 24-24h74.411l34.018-56.696A48 48 0 0 1 173.589 0h100.823a48 48 0 0 1 41.16 23.304L349.589 80H424zm-269.611 0h139.223L276.16 50.913A6 6 0 0 0 271.015 48h-94.028a6 6 0 0 0-5.145 2.913L154.389 80zM368 128H80v330a6 6 0 0 0 6 6h276a6 6 0 0 0 6-6V128z"></path></svg>
								</div>
							</div>
						</li>
					</ul>
				</div>

			</section>
		</div>
		--}}
	</div>

	<div class="section-container2"></div>

	<template id="skeleton-card-section">
		<div class="w-full mt-10 md:mx-auto md:w-2/3 lg:w-1/2">
			<section class="section-card-entries">
				<h3 class="section-title" bind-section-title></h3>
				<div class="card-container" bind-cards></div>
			</section>
		</div>
	</template>
	<template id="skeleton-card-entry">
		<div class="card-entry">
			<div class="card-inner">
				<div class="card-titlebar">
					<div class="z-10 w-1/2 transition-colors duration-200 cursor-pointer hover:bg-primary-700 hover:text-green-500">
						<svg class="h-6 m-2 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
						</svg>
					</div>
					<div class="z-10 w-1/2 transition-colors duration-200 cursor-pointer hover:bg-primary-700 hover:text-red-500">
						<svg class="h-6 m-2 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
						</svg>
					</div>
				</div>
				<div class="card-meta">
					<h4 class="text-2xl text-center" bind-ident1></h4>
					<div class="mt-2 tracking-widest text-center">
						<div class="" bind-ident2>PC</div>
						<div class="" bind-release>Thu, 03 Dec 2020</div>
					</div>
				</div>

				<div class="card-visibility" bind-visibility></div>
			</div>
		</div>
	</template>

	{{--<div class="w-full mt-10 md:mx-auto md:w-2/3 lg:w-1/2">
		<section class="section-card-entries">
			<h3 class="section-title">CDs</h3>

			<div class="card-container">
				<div class="card-entry">
					<div class="card-inner">
						<div class="card-titlebar">
							<div class="z-10 w-1/2 transition-colors duration-200 cursor-pointer hover:bg-primary-700 hover:text-green-500">
								<svg class="h-6 m-2 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
								</svg>
							</div>
							<div class="z-10 w-1/2 transition-colors duration-200 cursor-pointer hover:bg-primary-700 hover:text-red-500">
								<svg class="h-6 m-2 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
								</svg>
							</div>
						</div>
						<div class="p-2 mt-4 card-meta">
							<h4 class="text-2xl text-center">
								Immortals Fenyx Rising
							</h4>
							<div class="mt-6 tracking-widest text-center">
								<div class="">PC</div>
								<div class="">Thu, 03 Dec 2020</div>
							</div>
						</div>

						<div class="card-visibility card-visibility--red"></div>
					</div>
				</div>

				<div class="card-entry">
					<div class="card-inner">
						<div class="card-titlebar">
							<div class="z-10 w-1/2 transition-colors duration-200 cursor-pointer hover:bg-primary-700 hover:text-green-500">
								<svg class="h-6 m-2 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
								</svg>
							</div>
							<div class="z-10 w-1/2 transition-colors duration-200 cursor-pointer hover:bg-primary-700 hover:text-red-500">
								<svg class="h-6 m-2 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
								</svg>
							</div>
						</div>
						<div class="p-2 mt-4 card-meta">
							<h4 class="text-2xl text-center">
								Immortals Fenyx Rising
							</h4>
							<div class="mt-6 tracking-widest text-center">
								<div class="">Switch</div>
								<div class="">Thu, 03 Dec 2020</div>
							</div>
						</div>

						<div class="card-visibility card-visibility--orange"></div>
					</div>
				</div>

				<div class="card-entry">
					<div class="card-inner">
						<div class="card-titlebar">
							<div class="z-10 w-1/2 transition-colors duration-200 cursor-pointer hover:bg-primary-700 hover:text-green-500">
								<svg class="h-6 m-2 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
								</svg>
							</div>
							<div class="z-10 w-1/2 transition-colors duration-200 cursor-pointer hover:bg-primary-700 hover:text-red-500">
								<svg class="h-6 m-2 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
								</svg>
							</div>
						</div>
						<div class="p-2 mt-4 card-meta">
							<h4 class="text-2xl text-center">
								Immortals Fenyx Rising
							</h4>
							<div class="mt-6 tracking-widest text-center">
								<div class="">PlayStation</div>
								<div class="">Thu, 03 Dec 2020</div>
							</div>
						</div>

						<div class="card-visibility card-visibility--green"></div>
					</div>
				</div>
			</div>
		</section>
	</div>--}}

	<button class="fixed bottom-0 left-0 mb-10 ml-10 btn btn-default js-render">Render</button>
	<button class="fixed bottom-0 right-0 mb-10 mr-10 btn btn-default js-render2">Render2</button>

	
	<template id="modal-remove-confirm">
		<div>
			<h2 class="mb-4 text-xl font-bold text-center">Do you want to remove this entry?</h2>
			<div class="w-full">
				<div class="mt-4 text-xl">
					<div class="text-center" bind-name></div>
					<div class="flex flex-row justify-center">
						<div bind-ident1></div>
						<span class="mx-2">-</span>
						<div bind-ident2></div>
					</div>
					<div class="text-center" bind-release></div>
				</div>

				<div class="mt-4 text-center">
					<p>Do you really want to delete this Entry?</p>
				</div>

				<div class="flex flex-row justify-between mt-8">
					<button class="btn btn-success btn-icon js-modal-confirm" type="button" bind-entry-id>
						<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Remove
					</button>

					<button class="btn btn-default btn-icon js-modal-close" type="button">
						<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> Cancel
					</button>
				</div>
			</div>
		</div>
	</template>

	<template id="modal-entry">
		<div>
			<h2 class="mb-4 text-xl font-bold">Add a new Entry</h2>
			<div class="w-full">
				<form method="POST" action="/">
					<div>
						<label class="block">
							<span class="block mb-1 font-bold">Type</span>
							<select class="w-1/2 form-select" name="type" bind-types>
								{{-- dynamically filled --}}
							</select>
						</label>
						<span class="block mt-1 text-sm">
							Where should this type be listed in.
						</span>
					</div>
					<div class="mt-4">
						<label class="block">
							<span class="block mb-1 font-bold" bind-ident1></span>
							<input class="block w-full form-input" name="ident_1" type="text" placeholder="" value="" required>
						</label>

						<span class="block mt-1 text-sm">
							Usually the name of an author, or an artist, the title for a book or similar.
						</span>
					</div>
					<div class="mt-4">
						<label class="block">
							<span class="block mb-1 font-bold" bind-ident2></span>
							<input class="block w-full form-input" name="ident_2" type="text" value="" placeholder="" required>
						</label>

						<span class="block mt-1 text-sm">
							Something describing the new entry a bit more. Like album/book title, or season number. If empty, it will be set to "TBA".
						</span>
					</div>

					<div class="mt-4">
						<label class="block">
							<span class="block mb-1 font-bold">Release</span>
							<input class="block w-1/2 form-input" name="release" type="date" value="" required>
						</label>

						<span class="block mt-1 text-sm">
							The date of the entry. If unknown and kept blank, TBA will be set.
						</span>
					</div>
					
					<div class="mt-4">
						<span class="block mb-1 font-bold">Visibility</span>
						<div class="flex flex-row w-full">
							<label class="w-1/3 p-1 mr-1 text-center bg-green-300 rounded cursor-pointer">
								<input class="invisible form-radio" name="visibility" type="radio" value="1" checked>
								Hidden
							</label>
							<label class="w-1/3 p-1 mr-1 text-center bg-orange-300 rounded cursor-pointer">
								<input class="invisible form-radio" name="visibility" type="radio" value="2">
								Private
							</label>
							<label class="w-1/3 p-1 mr-1 text-center bg-red-300 rounded cursor-pointer">
								<input class="invisible form-radio" name="visibility" type="radio" value="4">
								Public
							</label>
						</div>
					</div>

					<div class="flex flex-row justify-between mt-8">
						<button class="btn btn-success btn-icon js-save-entry" type="button">
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
	<script>
		(function() {
			let skSection = document.querySelector('#skeleton-table-section');
			let skTable = document.querySelector('#skeleton-table');
			let skEntry = document.querySelector('#skeleton-table-entry');

			// Container holding all sections
			let sectionContainer = document.querySelector('.section-container');

			let renderFunc = function() {
				sectionContainer.innerHTML = '';

				for (let i = 0; i < Math.abs(Math.floor(Math.random() * 10) - Math.floor(Math.random() * 10))+2; ++i) {
					let _div = document.createElement('div');
					// new display type section, here: table section
					let newSection = skSection.innerHTML.slice(0);
						_div.innerHTML = newSection;
						newSection = _div.firstElementChild;
						newSection.querySelector('h3[bind-section-title]').innerHTML = `TEST${ i+1 }`;

					_div = document.createElement('div');
					// new table head
					let newTable = skTable.innerHTML.slice(0);
						_div.innerHTML = newTable;
						newTable = _div.firstElementChild;
						newTable.querySelector('div[bind-ident1]').innerHTML = `Ident 1${ i }`;
						newTable.querySelector('div[bind-ident2]').innerHTML = `Ident 2${ i }`;

					for (let k = 0; k < Math.abs(Math.floor(Math.random() * 10) - Math.floor(Math.random() * 10))+2; ++k) {
						_div = document.createElement('div');
						// new entry for new table
						let newEntry = skEntry.innerHTML.slice(0);
							_div.innerHTML = newEntry;
							newEntry = _div.firstElementChild;
							newEntry.querySelector('div[bind-ident1]').innerHTML = `Ident A${ k }`;
							newEntry.querySelector('div[bind-ident2]').innerHTML = `Ident B${ k }`;
							newEntry.querySelector('div[bind-release]').innerHTML = 'Release';
						
						newTable.appendChild(newEntry);
					}

					newSection.querySelector('div[bind-table]').appendChild(newTable);
					sectionContainer.appendChild(newSection);
				}
			};
			//renderFunc();

			let btn = document.querySelector('.js-render');
				btn.addEventListener('click', e => renderFunc());
		})();

		(function() {
			let skSection = document.querySelector('#skeleton-card-section');
			let skEntry = document.querySelector('#skeleton-card-entry');

			// Container holding all sections
			let sectionContainer = document.querySelector('.section-container2');

			let renderFunc = function() {
				sectionContainer.innerHTML = '';

				for (let i = 0; i < Math.abs(Math.floor(Math.random() * 10) - Math.floor(Math.random() * 10))+2; ++i) {
					let _div = document.createElement('div');
					// new display type section, here: table section
					let newSection = skSection.innerHTML.slice(0);
						_div.innerHTML = newSection;
						newSection = _div.firstElementChild;
						newSection.querySelector('h3[bind-section-title]').innerHTML = `TEST${ i+1 }`;

					for (let k = 0; k < Math.abs(Math.floor(Math.random() * 10) - Math.floor(Math.random() * 10))+102; ++k) {
						_div = document.createElement('div');
						// new entry for new table
						let newEntry = skEntry.innerHTML.slice(0);
							_div.innerHTML = newEntry;
							newEntry = _div.firstElementChild;
							newEntry.querySelector('h4[bind-ident1]').innerHTML = `Ident A${ k }`;
							newEntry.querySelector('div[bind-ident2]').innerHTML = `Ident B${ k }`;
							newEntry.querySelector('div[bind-release]').innerHTML = 'Release';
							let visibility = newEntry.querySelector('div[bind-visibility]');
								visibility.classList.add('card-visibility--' + ['red', 'green', 'orange'][Math.floor(Math.random() * 3)]);
								visibility.setAttribute('title', Math.floor(Math.random() * 1000));

						newSection.querySelector('div[bind-cards]').appendChild(newEntry);
					}

					sectionContainer.appendChild(newSection);
				}
			};
			//renderFunc();

			let btn = document.querySelector('.js-render2');
				btn.addEventListener('click', e => renderFunc());
		})();
	</script>
	<script src="{{ mix('/js/profile.js') }}"></script>
@endsection
