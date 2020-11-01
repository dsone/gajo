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
			<div class="flex flex-row justify-end w-1/12 pr-2">
				<div class="z-10 w-1/2 transition-colors duration-200 hover:text-green-500" bind-edit>
					<svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
					</svg>
				</div>
				<div class="z-10 w-1/2 transition-colors duration-200 hover:text-red-500" bind-remove>
					<svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
					</svg>
				</div>
			</div>
		</div>

		<div class="entry-visibility" bind-visibility></div>
	</li>
</template>