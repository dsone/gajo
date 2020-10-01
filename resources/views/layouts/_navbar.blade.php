<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
<div class="main-navbar">
	<div class="antialiased">
		<div class="w-full text-white bg-primary-500">
			<div x-data="{ open: false }" class="flex flex-col max-w-screen-xl px-4 mx-auto md:items-center md:justify-between md:flex-row md:px-6 lg:px-8">
				<div class="flex flex-row items-center justify-between p-2">
					<a href="#" class="text-lg font-semibold tracking-widest uppercase rounded-lg dark-mode:text-white focus:outline-none focus:shadow-outline">
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

					<button class="rounded-lg md:hidden focus:outline-none focus:shadow-outline" @click="open = !open">
						<svg fill="currentColor" viewBox="0 0 20 20" class="w-6 h-6">
							<path x-show="!open" fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM9 15a1 1 0 011-1h6a1 1 0 110 2h-6a1 1 0 01-1-1z" clip-rule="evenodd"></path>
							<path x-show="open" fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
						</svg>
					</button>
				</div>
				<nav :class="{'flex': open, 'hidden': !open}" class="flex-col flex-grow hidden pb-4 md:pb-0 md:flex md:justify-end md:flex-row">
					@auth
						<button class="hidden px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg md:mt-0 focus:outline-none focus:shadow-outline md:inline-block" href="#">
							Add
						</button>
						<a class="px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg md:mt-0 md:ml-4 focus:outline-none focus:shadow-outline" href="{{ route('user-profile', [ 'user' => \Auth::user()->name ]) }}">
							Profile
						</a>
						<a class="px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg md:mt-0 md:ml-4 focus:outline-none focus:shadow-outline" href="{{ route('user-options', [ 'user' => \Auth::user()->name ]) }}">
							Options
						</a>
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