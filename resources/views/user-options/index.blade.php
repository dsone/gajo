@extends('index')
@section('title', 'Options - ' . config('app.name', ''))

@section('content')
<div class="container js-page-options">
    <h1 class="title">Options</h1>
    <hr>
    <section class="content">
        <h3>Profile</h3>
        <div class="field">
            <label class="label">Private Profile</label>
            <input id="private-profile" type="checkbox" class="switch is-rounded is-success js-private-profile" @if($options->private)checked="checked" @endif>
            <label for="private-profile">Enable private profile</label>
            <p class="help">If this is enabled, you can only see your list when logged in, or through RSS links. Accessing your profile from outside will redirect to the login page. Default: yes.</p>
        </div>
        <div class="field">
            <label class="label">Colorblind mode</label>
            <input id="colorblind-mode" type="checkbox" class="switch is-rounded is-success js-colorblind-mode" @if($options->colorblind)checked="checked" @endif>
            <label for="colorblind-mode">Enable color blind mode</label>
            <p class="help">Gajo uses color to differentiate released, soon-to-be and future release entries. You cannot differentiate the states because of color blindness or you want to be more accessible? Then simply enable this mode. Default: no.</p>
        </div>
    </section>
    <section class="content">
        <h3>RSS</h3>
        <div class="field has-addons">
            <p class="control is-expanded has-icons-left">
                <input class="input js-input-rss" type="text" value="{{ $options->rss }}" readonly>
                <span class="icon is-small is-left">@svg('solid/rss')</span>
            </p>
            <p class="control">
                <a href="#" class="button js-btn-change-rss">@svg('solid/sync-alt', 'icon-sm')&nbsp;Change</a>
            </p>
            <p class="control">
                <a href="{{ route('user-rss', [ 'user' => $user->name, 'id' => $options->rss ]) }}" class="button js-btn-rss-link" target="_blank" data-route="{{ route('user-rss', [ 'user' => $user->name, 'id' => '' ]) }}/">@svg('solid/rss', 'icon-sm')&nbsp;Link</a>
            </p>
        </div>
        <p class="field help">This is your RSS link for your list. Each user has a unique id to use. You can change your ID as often as you want. But you have to update your RSS feed Reader to use the new ID.</p>
    </section>
    <section class="content">
        <h3>List</h3>
        <div class="field">
            <label class="label">Hide Released</label>
            <input id="hide-released" type="checkbox" class="switch is-rounded is-success js-hide-released" @if($options->hideReleased)checked="checked" @endif>
            <label for="hide-released">Automatically hide released media</label>
            <p class="help">If this is enabled, releases that are in the past, are not displayed on your public list anymore. This helps keeping your list tidy. Default: yes.</p>
        </div>
        <div class="field">
            <label class="label">Hide TBA</label>
            <input id="hide-tba" type="checkbox" class="switch is-rounded is-success js-hide-tba" @if($options->hideTBA)checked="checked" @endif>
            <label for="hide-tba">Automatically hide TBAs</label>
            <p class="help">If this is enabled, releases that have not yet a name and/or no release date they are hidden from your public list. If you have many releases that are only rumored, or are pushed back multiple times already, you can use this to further tidy up your list. Default: yes.</p>
        </div>
    </section>
    <section class="content">
        <h3>Types</h3>
        <p class="field">
            These are the groups for your list. You could also call these categories, or groups. One type can be a CD for example, or a Book. Whereas each Type has its own two "identifications", making entries distinguishable from each other. A book has an author and a title for example, while a CD has usually an artist and a name.<br>
            You can choose as many types as you want.
        </p>
        <h4>Available types in order</h4>
        <div class="js-types-container">
            {{-- Filled in JavaScript at runtime --}}
        </div>
        <div class="types-buttons">
            <button class="button is-success js-btn-add-type" data-target="#modal-add-type">New Type</button>
            <div class="modal" id="modal-add-type">
                <div class="modal-background close-modal"></div>
                <div class="modal-card">
                    <header class="modal-card-head">
                        <p class="modal-card-title">Add a new type</p>
                        <button class="delete close-modal"></button>
                    </header>
                    <section class="modal-card-body">
                        <div class="field">
                            <label class="label">Name</label>
                            <div class="control">
                                <input class="input js-new-type-name" type="text" placeholder="Name" required>
                            </div>
                            <p class="help">The name for your Type. Will be displayed as a header.</p>
                        </div>
                        <div class="field">
                            <label class="label">Descriptor 1</label>
                            <div class="control">
                                <input class="input js-new-type-descriptor1" type="text" placeholder="Descriptor 1" required>
                            </div>
                            <p class="help">A further describing attribute, ie. the Artist for a CD, or the Author for book or similar.</p>
                        </div>
                        <div class="field">
                            <label class="label">Descriptor 2</label>
                            <div class="control">
                                <input class="input js-new-type-descriptor2" type="text" placeholder="Descriptor 2" required>
                            </div>
                            <p class="help">The second attribute, usually the tile or name, like of a record, or of a book.</p>
                        </div>

                        <div class="field">
                            <label class="label">Display style</label>
                            <div class="control">
                                <span class="select">
                                    <select class="js-type-display">
                                        <option value="1">List Display</option>
                                        <option value="2">Card Display</option>
                                    </select>
                                </span>
                            </div>
                            <p class="help">
                               How should this type be displayed? List is default, but Card if for the occasions where you want something fancy.
                            </p>
                        </div>
                    </section>
                    <footer class="modal-card-foot">
                        <a class="button is-primary save-type">Save</a>
                        <a class="button close-modal">Cancel</a>
                    </footer>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection