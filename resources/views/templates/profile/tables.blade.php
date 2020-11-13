<template id="sortby-ascending-icon">
	<svg class="inline h-4 ml-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
		<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12" />
	</svg>
</template>
<template id="sortby-descending-icon">
	<svg class="inline h-4 ml-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
		<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h9m5-4v12m0 0l-4-4m4 4l4-4" />
	</svg>
</template>
<template id="skeleton-table-section">
	<div class="w-full mt-10 md:mx-auto md:w-3/4 lg:w-2/3">
		<section class="section-table-entries">
			<h3 class="section-title" bind-section-title></h3>

			<div class="px-4" bind-table>
				{{-- #table-skeleton --}}
			</div>
		</section>
	</div>
</template>
<template id="skeleton-table">
	<ul class="table-entries">
		<li class="select-none table-headline">
			<div class="flex flex-col md:flex-row thead">
				<div class="w-full mb-2 text-center md:mb-0 md:text-left md:w-4/12 xl:w-5/12">
					<span bind-ident1 sortby="ident_1"></span>
				</div>
				<div class="w-full mb-2 text-center md:mb-0 md:text-left md:w-4/12 xl:w-4/12">
					<span bind-ident2 sortby="ident_2"></span>
				</div>
				<div class="w-full mb-2 text-center md:mb-0 md:text-left md:w-2/12 xl:w-2/12">
					<span sortby="release_at">Release</span>
				</div>
				<div class="hidden md:block md:w-2/12 xl:w-1/12" private>&nbsp;</div>
			</div>
		</li>
		{{-- #table-list-entry --}}
	</ul>
</template>
<template id="skeleton-table-entry">
	<li class="table-entry">
		<div class="flex flex-col md:flex-row tbody" bind-edit="dblclick">
			<div class="flex flex-row w-full md:w-4/12 xl:w-5/12">
				<div class="absolute top-0 left-0 mt-3 ml-3 text-black entry-availability cursor-help" bind-availability>
					<svg class="h-4 mb-1 text-red-800 svg-icon release-available" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" title="Release available">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
					</svg>

					<svg class="h-4 mb-1 text-orange-700 svg-icon release-48-hours" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" title="Release within 48 hours">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
					</svg>

					<svg class="h-4 mb-1 text-green-800 svg-icon release-1-week" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" title="Release within 1 week">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
					</svg>
					<span class="release-later" title=""></span>
				</div>
				<div class="w-full ml-6 font-bold text-center md:w-10/12 md:text-left md:font-normal" bind-ident1></div>
			</div>
			<div class="w-full text-center md:text-left md:w-4/12 xl:w-4/12" bind-ident2></div>
			<div class="w-full mt-1 text-sm italic text-center md:text-left md:w-2/12 xl:w-1/12 md:text-base md:not-italic md:mt-0" bind-release></div>
			<div class="w-full text-center md:text-left md:w-2/12 xl:w-2/12 entry-options" private>
				<div class="z-10 mr-2 transition-colors duration-200 lg:mr-4 hover:text-green-500" bind-edit="click">
					<svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
					</svg>
				</div>
				<div class="z-10 mr-2 transition-colors duration-200 lg:mr-4 hover:text-red-500" bind-remove>
					<svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
					</svg>
				</div>
			</div>
		</div>

		<div class="entry-visibility" bind-visibility private>
			<svg class="hidden svg-icon icon-green" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" icon-green>
				<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
			</svg>
			<svg class="hidden svg-icon icon-orange" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" icon-orange>
				<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
			</svg>
			<svg class="hidden svg-icon icon-red" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" icon-red>
				<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
				<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
			</svg>
		</div>
	</li>
</template>