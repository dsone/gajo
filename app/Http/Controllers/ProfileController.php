<?php

namespace Gajo\Http\Controllers;

use Roumen\Feed\Feed;
use Illuminate\Http\Request;

class ProfileController extends Controller {
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        //$this->middleware('auth');
    }

    /**
     * Show the user profile
     *
     * @return \Illuminate\Http\Response
     */
    public function index($user) {
        $u = \Gajo\User::where('name', $user)->first();

        // User not found, or the profile is set to private and it's not the logged in user accessing that same profile
        if (!$u || $u->options->private && (!\Auth::user() || \Auth::user()->name != $user)) {
            return view('user-profile.forbidden');
        }

        $entries = [];
        if (!\Auth::user() || \Auth::user()->name != $user) {
            $entries = $u->entries()->with(['Type'])
                         ->where('visibility', '>=', config('app.settings.list.visibility.public'))
                         ->orderBy('ident_2');

            // Have internally 1970 as dates, model converts them to null
            if ($u->options->hideTBA && !$u->options->hideReleased) {
                $entries = $entries
                        ->where('release_at', '>=', \Carbon\Carbon::create(1971, 1, 1, 0, 0, 0))
                        ->where('ident_2', '!=', 'TBA');
            // Hiding released only but display TBAs
            } else if ($u->options->hideReleased && !$u->options->hideTBA) {
                $entries = $entries
                        ->where('release_at', '>', \Carbon\Carbon::now()->startOfDay())
                        ->OrWhere('release_at', '=', \Carbon\Carbon::create(1970, 1, 1, 0, 0, 0));
            } else if ($u->options->hideTBA && $u->options->hideReleased) {  // hide both
                $entries = $entries
                        ->where('release_at', '>', \Carbon\Carbon::now()->startOfDay())
                        ->where('ident_2', '!=', 'TBA');
            }
            $entries = $entries->get();
        } else {
            $entries = $u->entries()->with(['Type'])->orderBy('ident_1')->get();
        }

        $rel = [];
        foreach ($entries as $r) {
            $key = $r->Type->sort . '_' . $r->Type->name;
            if (!isset($rel[$key])) {
                $rel[$key] = [
                    'type' => $r->Type,
                    'data' => []
                ];
            }
            $rel[$key]['data'][] = $r;
        }
        asort($rel);

        return view('user-profile.index', [
            'userName' => $user,
            'types' => $u->types,
            'entries' => $rel,
            'options' => [
                'colorblind' => $u->options->colorblind
            ]
        ]);
    }

    public function rss($user, $id) {
        $u = \Gajo\User::where('name', $user)->with(['options'])->first();
        $feed = new Feed();

        if ($u === null || $u->options->private || $id !== $u->options->rss) {
            $feed->title = 'Gajo - Release list';
            $feed->description = 'Gajo is a reminder for releases in the (far) future.';
            $feed->link = route('index');
            $feed->setDateFormat('datetime'); // 'datetime', 'timestamp' or 'carbon'
            $feed->pubdate = \Carbon\Carbon::now()->toRssString();
            $feed->lang = 'en';
            $feed->setShortening(true); // true or false
            $feed->setTextLimit(50); // maximum length of description text
            $feed->add(
                "404 - NOT FOUND", "Gajo",
                route('index'), $feed->pubdate,
                '', 'Whatever you were looking for is not here.'
            );
            return $feed->render('atom', 0);
        }

        $entries = $u->entries()
                     ->with(['Type'])
                     ->where('visibility', '>=', config('app.settings.list.visibility.private'))
                     ->orderBy('release_at')
                     ->get()->toArray();
        usort($entries, function($a, $b) {
            if ($a['release_at'] === null) { return 1; }
            else if ($b['release_at'] === null) { return -1; }

            return $a['release_at'] <=> $b['release_at'];
        });

        // cache the feed for 30 minutes (second parameter is optional)
        $feed->setCache(5, 'feedKey'.$u->id);

        // check if there is cached feed and build new only if is not
        if (!$feed->isCached()) {
            $feed->title = 'Gajo - ' . $u->name . ' release list';
            $feed->description = 'Release list data for ' . $u->name;
            $feed->link = route('user-rss', [ 'user' => $u->name, 'id' => $u->options->rss ]);
            $feed->setDateFormat('datetime'); // 'datetime', 'timestamp' or 'carbon'
            $feed->pubdate = \Carbon\Carbon::now()->toRssString();
            $feed->lang = 'en';
            $feed->setShortening(true); // true or false
            $feed->setTextLimit(50); // maximum length of description text

            $currentDate = \Carbon\Carbon::now();
            $immediateRange = \Carbon\Carbon::now()->startOfDay()->addDays(2);
            $soonRange = \Carbon\Carbon::now()->startOfDay()->addDays(7);
            $userProfile = route('user-profile', [ 'user' => $u->name ]);
            foreach ($entries as $entry) {
                $parsedReleaseAt = strlen($entry['release_at']) > 0 ? \Carbon\Carbon::parse($entry['release_at']) : null;
                if ($parsedReleaseAt === null) { continue; }

                $isReleased = $parsedReleaseAt->lt($currentDate);
                $isImmediate = $parsedReleaseAt->lt($immediateRange);
                $isSoon = $parsedReleaseAt->lt($soonRange);

                $content = '';
                if ($isReleased) {
                    $content = $entry['ident_2'] . ' was already released!';
                } else if ($isImmediate) {
                    $content = $entry['ident_2'] . ' is going to be released within 48 hours!';
                } else if ($isSoon) {
                    $content = $entry['ident_2'] . ' will be released soon!';
                } else {
                    $content = "{$entry['ident_2']} ({$entry['ident_1']}) is scheduled for {$parsedReleaseAt->format('l jS \\of F')}.";
                }

                // set item's title, author, url, pubdate, description, content, enclosure (optional)*
                $feed->add(
                    "{$entry['type']['name']}: {$entry['ident_1']} - {$entry['ident_2']}",
                    $u->name,
                    $userProfile,
                    $entry['updated_at'],
                    $entry['ident_1'],
                    $content
                );
            }
        }
        return $feed->render('atom', 0);
    }
}
