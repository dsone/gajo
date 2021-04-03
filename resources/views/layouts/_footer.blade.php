<footer class="main-footer">
	<div class="mx-auto md:w-2/4">
		<ul class="flex justify-between text-center">
			<li class="flex-1">
				&copy; {{ Carbon\Carbon::now()->year }}
			</li>
			<li class="flex-1">
				<a class="hover:underline" href="{{ route('page-privacy') }}" target="_self">Privacy</a>
			</li>
		</ul>
	</div>
</footer>