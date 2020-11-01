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
					<button class="btn btn-success btn-icon js-modal-confirm" type="button">
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