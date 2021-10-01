<?php

namespace App\Http\Controllers;

use Auth;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Option;
use Illuminate\Support\Facades\App;

class ProfileController extends Controller {
	/**
	 * Show the user profile
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index($user) {
		$authUser = Auth::user();
		// Auth'd user tries to access own profile, but has no verified mail
		if ($authUser && $authUser->name === $user && !$authUser->hasVerifiedEmail()) {
			return redirect()->route('verification.notice', 303);
		}

		// User or 404
		$userProfile = $authUser && $authUser->name === $user ? $authUser : User::where('name', $user)->firstOrFail();
		$ownProfile = $authUser && $authUser->name === $user;
		
		// Other user's profile, but that user has no verified mail or is in privatemode
		if (!$userProfile->hasVerifiedEmail() || (!$ownProfile && $userProfile->options->privateProfile)) {
			abort(404);
		}

		$types = null;
		if (!$ownProfile) {
			$types = $userProfile->types()->whereHas('entries')->with('entries', function($q) use($userProfile) {
						$q->where('visibility', '>=', config('gajo.settings.list.visibility.public'));

						if ($userProfile->options->hideReleased) {
							$q->where('release_at', '>', Carbon::now()->startOfDay()->format('c'));
						}
						if ($userProfile->options->hideTBA) {
							$q->where('ident_2', '!=', 'TBA')->where('entries.release_at', '!=', null);
						}
						$q->orderBy('ident_1');
					});
			$types = $types->get();
		} else {
			$types = $authUser->types()->with([ 'entries' ])->get();
		}

		return view('user.profile', [
				'user'			=> $userProfile,
				'types'			=> $types,
				'ownProfile'	=> $ownProfile,
			]);
	}

	/**
	 * Show the user's rss feed
	 * 
	 * @param	string	$token		The secret RSS token to use.
	 * @return \Illuminate\Http\Response
	 */
	public function rss($token) {
		$options = Option::where('rss', $token)->with([ 'user' ])->first();
		if (!$options || $options->privateProfile || !$options->user->hasVerifiedEmail()) {
			abort(404);
		}
		
		// create new feed
		$feed = App::make("feed");

		//$feed->setCache(30, 'rss_feed_' . $options->user->name);
		if (true/*!$feed->isCached()*/) {
			$types = $options->user->types()->whereHas('entries')->with('entries', function($q) use($options) {
						$q->where('visibility', '>=', config('gajo.settings.list.visibility.public'));

						if ($options->hideReleased) {
							$q->where('release_at', '>', Carbon::now()->startOfDay()->format('c'));
						}
						if ($options->hideTBA) {
							$q->where('ident_2', '!=', 'TBA')->where('entries.release_at', '!=', null);
						}
						$q->orderBy('ident_1');
					})->get();

			// set your feed's title, description, link, pubdate and language
			$feed->title = 'Gajo RSS | ' . $options->user->name;
			$feed->description = 'This is ' . $options->user->name . '\'s reminder for upcoming releases.';
			$feed->logo = route('index') . '/favicon.ico';
			$feed->link = route('user-rss', [ 'token' => $token ]);
			$feed->setDateFormat('datetime');
			$feed->lang = 'en';
			$feed->setShortening(true);

			$userProfileUrl = route('user-profile', [ 'user' => $options->user->name ]);
			$currentDate = Carbon::now()->setTimezone('utc')->startOfDay();
			$immediateRange = Carbon::now()->setTimezone('utc')->addDays(2);
			$soonRange = Carbon::now()->setTimezone('utc')->addDays(7);
			$feedItems = [];
			foreach ($types as $type) {
				$name = "$type->name: ";
				foreach ($type->entries as $entry) {
					if ($entry->release_at === null || $entry->visibility < config('gajo.settings.list.visibility.private')) {
						continue;
					}

					// Prepare timestamp comparisons
					$releaseAt = Carbon::parse($entry->release_at);
					$isReleased = $releaseAt->lte($currentDate);
					$isImmediate = $releaseAt->lt($immediateRange);
					$isSoon = $releaseAt->lt($soonRange);

					if ($releaseAt->gt($isSoon) || $options->user->hideReleased && $isReleased || $options->user->hideTBA && $entry->ident_2 == 'TBA') {
						continue;
					}

					$content = '';
					$title = $name . "$entry->ident_1 - $entry->ident_2";
					if ($isReleased) {
						$content = "$entry->ident_1 - $entry->ident_2 has been released already!<br>Its release was {$releaseAt->format('l jS \\of F')}.";
						$title .= ' is available!';
					} else if ($isImmediate) {
						$content = "$entry->ident_1 - $entry->ident_2 is going to be released within 48 hours!";
						$title .= ' will be released within 48 hours!';
					} else if ($isSoon) {
						$content = "$entry->ident_1 - $entry->ident_2 will be released soon, in less than 7 days!";
						$title .= ' release is coming soon.';
					} else {
						$content = "$entry->ident_1 - $entry->ident_2 is scheduled to release on {$releaseAt->format('l jS \\of F')}.";
					}

					$feedItems[] = [
							'title'		=> $title,
							'author'	=> $options->user->name,
							'url'		=> $userProfileUrl,
							'link'		=> $userProfileUrl . "#$entry->id" . md5( $isReleased ? $releaseAt->addMinutes(5) : ($isImmediate ? $releaseAt->addMinutes(10) : ($isSoon ? $entry->release_at : $entry->updated_at )) ),
							'pubdate'	=> $entry->release_at,
							'description' => $entry->ident_1,
							'content'	=> $content
						];
					
				}
			}
			usort($feedItems, function($a, $b) { 
				return strcmp($a['pubdate'], $b['pubdate']);
			});
			foreach ($feedItems as $feedItem) {
				$feed->addItem($feedItem);
			}
		}

		return $feed->render('atom');
	}
}
