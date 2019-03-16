<?php

namespace Gajo\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class EntryController extends Controller {
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $data = $this->validate($request, [
            'ident_1' => 'required|string|min:2',
            'ident_2' => '',  // can be empty
            'release_at' => 'nullable|date',  // can be empty, hence nullable
            'type_id' => 'required|integer|min:1',
            'visibility' => 'required|integer|min:1',
        ]);

        $release_at = null;
        $release_at = strlen($data['release_at']) == 0 ? '1970-01-01T00:00:00.000Z' : $data['release_at'];
        $release_at = Carbon::instance(new \DateTime($release_at));

        $entry = null;
		try {
            $user = \Auth::user();
			$entry = \Gajo\Entry::create([
                'ident_1' => e($data['ident_1']),
                'ident_2' => e($data['ident_2']),
                'release_at' => $release_at,
                'visibility' => $data['visibility'],
                'type_id' => $data['type_id'],
                'user_id' => $user->id
            ]);
		} catch(\Exception $e) {
			return response()->json([
				'error' => true,
				'message' => $e->getMessage()
			]);
		}

		return response()->json([
            'error' => false,
            'entry' => $entry
        ]);
    }

    public function update(Request $request) {
        $data = $this->validate($request, [
            'id' =>         'required|integer|min:1',
            'ident_1' =>    'required|string|min:2',
            'ident_2' =>    '',  // can be empty
            'release_at' => 'nullable|date',  // can be empty, hence nullable
            'type_id' =>    'required|integer|min:1',
            'visibility' => 'required|integer|min:1',
        ]);

        $release_at = null;
        $release_at = strlen($data['release_at']) == 0 ? '1970-01-01T00:00:00.000Z' : $data['release_at'];
        $release_at = Carbon::instance(new \DateTime($release_at));

        $entry = null;
		try {
            $user = \Auth::user();
            $entry = \Gajo\Entry::where([
                'id' => $data['id'],
                'user_id' => $user->id
            ])->firstOrFail();

            $entry->ident_1 = e($data['ident_1']);
            $entry->ident_2 = e($data['ident_2']);
            $entry->release_at = $release_at;
            $entry->type_id = $data['type_id'];
            $entry->visibility = $data['visibility'];
            $entry->save();
		} catch(\Exception $e) {
			return response()->json([
				'error' => true,
				'message' => $e->getMessage()
			]);
		}

		return response()->json([
            'error' => false,
            'entry' => $entry
        ]);
    }

    public function changeVisibility(Request $request) {
        $data = $this->validate($request, [
            'id' => 'required|integer|min:1',
            'visibility' => 'required|integer|min:1',
        ]);

		try {
            $user = \Auth::user();
			$entry = \Gajo\Entry::where([
                'id' => $data['id'],
                'user_id' => $user->id
            ])->firstOrFail();
            $entry->visibility = $data['visibility'];
            $entry->save();
		} catch(\Exception $e) {
			return response()->json([
				'error' => true,
				'message' => $e->getMessage()
			]);
		}

		return response()->json([
            'error' => false,
            'entry' => $entry
        ]);
    }

    public function remove(Request $request) {
        $data = $this->validate($request, [
            'id' => 'required|integer|min:1'
        ]);

		try {
            $user = \Auth::user();
			$entry = \Gajo\Entry::where([
                'id' => $data['id'],
                'user_id' => $user->id
            ])->firstOrFail();
            $entry->delete();
		} catch(\Exception $e) {
			return response()->json([
				'error' => true,
				'message' => $e->getMessage()
			]);
		}

		return response()->json([
            'error' => false
        ]);
    }
}
