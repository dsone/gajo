<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta name="robots" content="index,follow">
        <meta name="revisit-after" content="7 days">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <base href="{{ env('APP_URL') }}/" />
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="Content-Language" content="{{ app()->getLocale() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="keywords" content="">
        <meta name="description" content="">
        <link type="image/x-icon" href="./favicon.ico" rel="shortcut icon">
        <title>@yield('title', config('app.name', ''))</title>
        <link href="{{ elixir('vendor/bulma/bulma.min.css', null) }}" rel="stylesheet">
        <link href="{{ elixir('css/app.css', null) }}" rel="stylesheet">
    </head>
    <body class="has-navbar-fixed-top{{ \Auth::user() ? ' is-user' : ' is-visitor' }}{{ isset($options) ? ($options['colorblind'] ? ' is-colorblind' : '') : '' }} @yield('body-class', 'is-page')">
        <div class="main-container">
            @include('navbar.index')

            <div class="main-content">
                @yield('content')
            </div>

            @include('footer.index')
        </div>

        <div class="notifications"></div>
        @auth
        <div class="modal" id="modal-add-entry">
            <div class="modal-background close-modal"></div>
            <div class="modal-card">
                <header class="modal-card-head">
                    <p class="modal-card-title">Add entry</p>
                    <button class="delete close-modal"></button>
                </header>
                <section class="modal-card-body">
                    <div class="field">
						<label class="label">Belongs to Type</label>
						<div class="control">
							<span class="select">
								<select class="js-entry-type">{{-- Filled in JavaScript --}}</select>
							</span>
						</div>
						<p class="help">
							Where should this type be listed in?
						</p>
					</div>
					<div class="field">
						<label class="label js-add-ident1"></label>
						<div class="control">
							<input class="input js-new-entry-ident-1" type="text" placeholder="" required>
						</div>
						<p class="help">Usually the name of an author, or an artist, the title for a book or similar.</p>
					</div>
					<div class="field">
						<label class="label js-add-ident2"></label>
						<div class="control">
							<input class="input js-new-entry-ident-2" type="text" placeholder="">
						</div>
						<p class="help">Something describing the new entry a bit more. Like album/book title, or season number. If empty, it will be set to "TBA".</p>
					</div>
					<div class="field">
						<label class="label">Release</label>
						<div class="control">
							<input class="input js-new-entry-release-at" type="date" placeholder="Release">
						</div>
						<p class="help">The date of the entry. If unknown and kept blank, TBA will be set.</p>
                    </div>
                    <div class="field">
                        <label class="label">Visibility</label>
                        <div class="control visibility-switch">
                            <input type="radio" id="ne-opt-hidden" name="visibility" data-visibility="{{ config('app.settings.list.visibility.hidden') }}" checked />
                            <label class="radio has-text-success" for="ne-opt-hidden"> Hidden <span title="Only visible on the website when logged in">@svg('regular/question-circle', 'icon-sm')</span></label>
                            <input type="radio" id="ne-opt-private" name="visibility" data-visibility="{{ config('app.settings.list.visibility.private') }}" />
                            <label class="radio has-text-warning" for="ne-opt-private"> Private <span title="Visible on the website when logged in and RSS">@svg('regular/question-circle', 'icon-sm')</span></label>
                            <input type="radio" id="ne-opt-public" name="visibility" data-visibility="{{ config('app.settings.list.visibility.public') }}" />
                            <label class="radio has-text-danger" for="ne-opt-public"> Public <span title="Visible everywhere">@svg('regular/question-circle', 'icon-sm')</span></label>
                        </div>
                    </div>
                </section>
                <footer class="modal-card-foot">
                    <a class="button is-primary save-modal">Add</a>
                    <a class="button close-modal">Cancel</a>
                </footer>
            </div>
        </div>

        <div class="modal" id="modal-remove-entry">
            <div class="modal-background close-modal"></div>
            <div class="modal-card">
                <header class="modal-card-head">
                    <p class="modal-card-title">Really delete this entry?</p>
                    <button class="delete close-modal"></button>
                </header>
                <section class="modal-card-body">
                    <div class="entry-ident1"></div>
                    <div class="entry-ident2"></div>
                    <div class="entry-release-at"></div>
                </section>
                <footer class="modal-card-foot">
                    <a class="button is-primary remove-modal">Remove</a>
                    <a class="button close-modal">Cancel</a>
                </footer>
            </div>
        </div>

        <div class="modal" id="modal-edit-entry">
            <div class="modal-background close-modal"></div>
            <div class="modal-card">
                <header class="modal-card-head">
                    <p class="modal-card-title">Edit entry</p>
                    <button class="delete close-modal"></button>
                </header>
                <section class="modal-card-body">
                    <div class="field">
						<label class="label">Belongs to Type</label>
						<div class="control">
							<span class="select">
								<select class="js-edit-entry-type">{{-- Filled in JavaScript --}}</select>
							</span>
						</div>
					</div>
					<div class="field">
						<label class="label js-edit-ident1"></label>
						<div class="control">
							<input class="input entry-ident1" type="text" required>
						</div>
					</div>
					<div class="field">
						<label class="label js-edit-ident2"></label>
						<div class="control">
							<input class="input entry-ident2" type="text">
						</div>
					</div>
					<div class="field">
						<label class="label">Entry</label>
						<div class="control">
							<input class="input entry-release-at" type="date" placeholder="Release">
						</div>
                    </div>
                    <div class="field">
                        <label class="label">Visibility</label>
                        <div class="control visibility-switch">
                            <input type="radio" id="ee-opt-hidden" name="visibility" data-visibility="{{ config('app.settings.list.visibility.hidden') }}" checked />
                            <label class="radio has-text-success" for="ee-opt-hidden"> Hidden <span title="Only visible on the website when logged in">@svg('regular/question-circle', 'icon-sm')</span></label>
                            <input type="radio" id="ee-opt-private" name="visibility" data-visibility="{{ config('app.settings.list.visibility.private') }}" />
                            <label class="radio has-text-warning" for="ee-opt-private"> Private <span title="Visible on the website when logged in and RSS">@svg('regular/question-circle', 'icon-sm')</span></label>
                            <input type="radio" id="ee-opt-public" name="visibility" data-visibility="{{ config('app.settings.list.visibility.public') }}" />
                            <label class="radio has-text-danger" for="ee-opt-public"> Public <span title="Visible everywhere">@svg('regular/question-circle', 'icon-sm')</span></label>
                        </div>
                    </div>
                </section>
                <footer class="modal-card-foot">
                    <a class="button is-primary edit-modal">Change</a>
                    <a class="button close-modal">Cancel</a>
                </footer>
            </div>
        </div>
        @endauth

        <script>
            var USER_TYPES = @json(($types ?? []));
            var ENTRIES = @json(($entries ?? []));
        </script>

        <div class="svg-container hidden">
            <span class="svg-eye">@svg('regular/eye')</span>
            <span class="svg-eye-slash">@svg('regular/eye-slash')</span>
            <span class="svg-eye-low">@svg('solid/low-vision')</span>
            <span class="svg-trash">@svg('regular/trash-alt')</span>
            <span class="svg-edit">@svg('regular/edit')</span>
            <span class="svg-triangle">@svg('solid/exclamation-triangle')</span>
            <span class="svg-stop">@svg('solid/ban')</span>
            <span class="svg-calendar">@svg('regular/calendar-alt')</span>

            <span class="svg-angle-up">@svg('solid/angle-up')</span>
            <span class="svg-angle-down">@svg('solid/angle-down')</span>
            <span class="svg-trash-alt">@svg('regular/trash-alt')</span>
        </div>

        <script src="{{ elixir('vendor/axios/axios.min.js', null) }}"></script>
        <script src="{{ elixir('js/app.js', null) }}"></script>
        @yield('footerJS')
    </body>
</html>