<template id="skeleton-card-section">
	<div class="w-full mt-10 md:mx-auto md:w-2/3 lg:w-1/2">
		<section class="section-card-entries">
			<h3 class="section-title" bind-section-title></h3>
			<div class="card-container" bind-cards></div>
		</section>
	</div>
</template>
<template id="skeleton-card-entry">
	<div class="card-entry" bind-edit="dblclick">
		<div class="card-inner">
			<div class="card-titlebar">
				<span class="w-0">&nbsp;</span> {{-- <- forces height in public mode when -v are removed --}}
				<div class="z-10 w-1/2 transition-colors duration-200 cursor-pointer hover:bg-primary-700 hover:text-green-500" bind-edit="click">
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

			<div class="absolute bottom-0 left-0 mb-4 ml-4 text-black card-availability cursor-help" bind-availability>
				<svg class="h-5 text-red-800 svg-icon release-available" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" title="Release available">
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
				</svg>

				<svg class="h-5 text-orange-700 svg-icon release-48-hours" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" title="Release within 48 hours">
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
				</svg>

				<svg class="h-5 text-green-800 svg-icon release-1-week" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" title="Release within 1 week">
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
				</svg>
				<span class="release-later" title=""></span>
			</div>

			<div class="card-visibility" bind-visibility private>
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
		</div>
	</div>
</template>