<template id="modal-type">
	<div>
		<h2 class="mb-4 text-xl font-bold">Add a new type</h2>
		<div class="w-full">
			<form method="POST" action="/">
				<div>
					<label class="block">
						<span class="block mb-1 font-bold">Name</span>
						<input class="block w-full form-input" name="name" type="text" placeholder="Name" value="{{ old('name') }}" autocomplete="off" required>
					</label>

					<div class="hidden mt-1 text-sm font-semibold text-red-700" error-name>
						This field is required and must be unique!
					</div>
					<div class="mt-1 text-sm ">
						The name for your Type. Will be displayed as a header.
					</div>
				</div>
				<div class="mt-4">
					<label class="block">
						<span class="block mb-1 font-bold">Descriptor 1</span>
						<input class="block w-full form-input" name="ident_1" type="text" value="" placeholder="Descriptor 1" autocomplete="off" required>
					</label>

					<div class="hidden mt-1 text-sm font-semibold text-red-700" error-ident1>
						This field is required!
					</div>
					<div class="mt-1 text-sm">
						A further describing attribute, ie. the Artist for a CD, or the Author for book or similar.
					</div>
				</div>

				<div class="mt-4">
					<label class="block">
						<span class="block mb-1 font-bold">Descriptor 2</span>
						<input class="block w-full form-input" name="ident_2" type="text" value="" placeholder="Descriptor 2" autocomplete="off" required>
					</label>

					<div class="hidden mt-1 text-sm font-semibold text-red-700" error-ident2>
						This field is required!
					</div>
					<div class="mt-1 text-sm">
						The second attribute, usually the tile or name, like of a record, or of a book.
					</div>
				</div>

				<div class="mt-4">
					<label class="block">
						<span class="block mb-1 font-bold">Display Style</span>
						<select class="w-full form-select" name="display">
							<option selected="selected" value="1">List Display</option>
							<option value="2">Card Display</option>
						</select>
					</label>
					<div class="mt-1 text-sm">
						How should this type be displayed? List is default, but Card if for the occasions where you want something fancy.
					</div>
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