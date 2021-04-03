<template id="modal-remove-confirm">
	<div disable-backdrop>
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