<div class="main-navbar">
	<div class="antialiased">
		<div class="w-full text-white bg-primary-500">
			<div class="flex flex-col max-w-screen-xl px-4 mx-auto md:items-center md:justify-between md:flex-row md:px-6 lg:px-8">
				<div class="flex flex-row items-center justify-between p-2">
					<a href="#" class="text-lg font-semibold tracking-widest uppercase rounded-lg app-name dark-mode:text-white focus:outline-none focus:shadow-outline">
						{{ env('APP_NAME') }}
						@hasSection('title') | 
						<span class="font-mono text-base tracking-normal lowercase">
							@yield('title', '')
						</span>
						@endif
					</a>

					@auth
						<button class="px-4 py-2 text-sm font-semibold bg-transparent rounded-lg focus:outline-none focus:shadow-outline md:hidden" href="#">
							Add
						</button>
					@endif

					<button class="rounded-lg md:hidden focus:outline-none focus:shadow-outline js-mobile-menu">
						<svg fill="currentColor" viewBox="0 0 20 20" class="w-6 h-6">
							<path class="js-icon-closed" fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM9 15a1 1 0 011-1h6a1 1 0 110 2h-6a1 1 0 01-1-1z" clip-rule="evenodd"></path>
							<path class="hidden js-icon-opened" fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
						</svg>
					</button>
				</div>
				<nav class="flex-col flex-grow hidden pb-4 md:pb-0 md:flex md:justify-end md:flex-row js-menu-items">
					@auth
						@if (Request::routeIs('user-profile') && ($ownProfile ?? false) && count($types) > 0)
						<button class="hidden px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg md:mt-0 focus:outline-none focus:shadow-outline md:inline-block js-navbar-add-entry" href="#">
							Add
						</button>
						@endif
						@if (!Request::routeIs('user-profile'))
						<a class="px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg md:mt-0 md:ml-4 focus:outline-none focus:shadow-outline" href="{{ route('user-profile', [ 'user' => \Auth::user()->name ]) }}">
							Profile
						</a>
						@endif
						@if (!Request::routeIs('user-options'))
						<a class="px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg md:mt-0 md:ml-4 focus:outline-none focus:shadow-outline" href="{{ route('user-options', [ 'user' => \Auth::user()->name ]) }}">
							Options
						</a>
						@endif
						<a class="px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg md:mt-0 md:ml-4 focus:outline-none focus:shadow-outline" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
							Logout
						</a>

						<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
					@else
						<a class="px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg md:mt-0 md:ml-4 focus:outline-none focus:shadow-outline" href="{{ route('login') }}" class="text-sm text-gray-700 underline">Login</a>

						@registerable
							<a class="px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg md:mt-0 md:ml-4 focus:outline-none focus:shadow-outline" href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 underline">Register</a>
						@endregisterable
					@endif
				</nav>
			</div>
		</div>
	</div>
</div>
<script>
	(function() {
		var open = false;

		var mobile = document.querySelector('.js-mobile-menu');
		var items = document.querySelector('.js-menu-items');
		var iconOpened = document.querySelector('.js-icon-opened');
		var iconClosed = document.querySelector('.js-icon-closed');

		mobile.addEventListener('click', function() {
			open = !open;

			if (open) {
				items.classList.add('flex');
				items.classList.remove('hidden');

				iconClosed.classList.add('hidden');
				iconOpened.classList.remove('hidden');
			} else {
				items.classList.add('hidden');
				items.classList.remove('flex');

				iconOpened.classList.add('hidden');
				iconClosed.classList.remove('hidden');
			}
		})
	})();
</script>