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
				&nbsp; {{-- <- forces height in public mode when -v are removed --}}
				<div class="z-10 w-1/2 transition-colors duration-200 cursor-pointer hover:bg-primary-700 hover:text-green-500" bind-edit>
					<svg class="h-6 m-2 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" private>
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
					</svg>
				</div>
				<div class="z-10 w-1/2 transition-colors duration-200 cursor-pointer hover:bg-primary-700 hover:text-red-500" bind-remove>
					<svg class="h-6 m-2 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" private>
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
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

			<div class="card-visibility" bind-visibility private></div>
		</div>
	</div>
</template>