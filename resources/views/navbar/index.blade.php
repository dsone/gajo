<nav class="navbar is-fixed-top" role="navigation" aria-label="main navigation">
    <div class="navbar-brand">
        <a class="navbar-item navbar-name" href="{{ route('index') }}">
            {{ env('APP_NAME') }}
        </a>
    </div>
    <div class="navbar-menu is-active">
        <div class="navbar-end">
            @auth
            <div class="navbar-item">
                <div class="nav-add-entry">
                    <p class="control">
                        {{-- The corresponding modal template is within index.balde.php --}}
                        <a class="button is-success js-link-add-entry" data-target="#modal-add-entry">
                            @svg('solid/plus', 'icon-sm')&nbsp;<span>Add</span>
                        </a>
                    </p>
                </div>
            </div>
            @endauth
            <div class="navbar-item">
                <div class="field is-grouped">
                    @guest
                    <p class="control">
                        <a class="button is-info" href="{{ route('login') }}">
                            @svg('solid/sign-in-alt')&nbsp;<span>Login</span>
                        </a>
                        @if(registerable())
                            <a class="button is-success" href="{{ route('register') }}" class="navbar-item">Register</a>
                        @endif
                    </p>
                    @else
                    <div class="field is-grouped">
                        <div class="dropdown is-right is-hoverable">
                            <div class="dropdown-trigger">
								<a href="#" onclick="event.preventDefault();" class="navbar-item" aria-haspopup="true" aria-controls="user-dropdown-menu">
									<span class="icon has-text-info">@svg('solid/user', 'icon-sm')</span>&nbsp;
									{{ Auth::user()->name }}&nbsp;
									<span class="icon is-small">@svg('solid/angle-down', 'icon-xs')</span>
								</a>
							</div>
							<div class="dropdown-menu" id="user-dropdown-menu" role="menu">
								<div class="dropdown-content">
									<div class="dropdown-item">
										<a href="{{ route('user-profile', [ 'user' => Auth::user()->name ]) }}">
											<span class="icon has-text-info">@svg('solid/user', 'icon-sm')</span>&nbsp;
											<span>Profile</span>
										</a>
									</div>
									<div class="dropdown-item">
										<a href="{{ route('user-options', [ 'user' => Auth::user()->name ]) }}">
											<span class="icon has-text-info">@svg('solid/user-cog', 'icon-sm')</span>&nbsp;
											<span>Options</span>
										</a>
									</div>
									<div class="dropdown-item">
										<a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
											<span class="icon has-text-danger">@svg('solid/sign-out-alt', 'icon-sm')</span>&nbsp;
											<span>Logout</span>
										</a>
										<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">{{ csrf_field() }}</form>
									</div>
								</div>
							</div>
						</div>
                    </div>
                    @endguest
                </div>
            </div>
        </div>
    </div>
</nav>