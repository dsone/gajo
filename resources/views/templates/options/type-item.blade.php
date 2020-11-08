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