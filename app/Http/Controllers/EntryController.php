<?php

namespace App\Http\Controllers;

use Auth;
use Carbon\Carbon;
use App\Models\Entry;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EntryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		$validated = $this->validate($request, [
						'type'			=> 'required|integer',
						'ident_1'		=> 'required|string',
						'ident_2'		=> 'nullable|string',
						'release'		=> 'nullable|date_format:"Y-m-d"',
						'visibility'	=> 'required|integer|min:1|max:4',
					]);

		$type = Auth::user()->types()->find($validated['type']);
		if (!$type) {
			return response()->json([
				'error' => true,
				'message' => 'Invalid Type provided!',
				'data' => []
			]);
		}

        $release = strlen($validated['release']) == 0 ? null : Carbon::instance(new \DateTime($validated['release']));

		$entry = null;
		try {
			$entry = Entry::create([
                'ident_1'		=> e($validated['ident_1']),
                'ident_2'		=> strlen($validated['ident_2']) === 0 ? 'TBA' : e($validated['ident_2']),
                'release_at'	=> $release,
                'visibility'	=> $validated['visibility'],
                'type_id'		=> $validated['type'],
                'user_id'		=> Auth::user()->id
            ]);
		} catch(\Exception $e) {
			return response()->json([
					'error' => true,
					'message' => 'You already have an entry with this information!'
				]);
		}

		return response()->json([
				'error' => false,
				'data' => [
					'entry' => $entry
				]
			]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Entry  $entry
     * @return \Illuminate\Http\Response
     */
    public function show(Entry $entry)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Entry  $entry
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Entry $entry)
    {
        $validated = $this->validate($request, [
						'id'			=> 'required|integer',
						'type'			=> 'required|integer',
						'ident_1'		=> 'required|string',
						'ident_2'		=> 'nullable|string',
						'release'		=> 'nullable|date_format:"Y-m-d"',
						'visibility'	=> 'required|integer|min:1|max:4',
					]);

		$user = Auth::user();
		$type = Auth::user()->types()->find($validated['type']);
		if (!$type) {
			return response()->json([
				'error' => true, 'message' => 'Type does not exist!'
			]);
		}
		
		$entry = Auth::user()->entries()->find($validated['id']);
		if (!$entry) {
			return response()->json([
				'error' => true, 'message' => 'Entry does not exist!'
			]);
		}

		try {
			$release = strlen($validated['release']) == 0 ? null : Carbon::instance(new \DateTime($validated['release']));
			$entry->update([
				'ident_1'		=> e($validated['ident_1']),
				'ident_2'		=> strlen($validated['ident_2']) === 0 ? 'TBA' : e($validated['ident_2']),
				'release_at'	=> $release,
				'visibility'	=> $validated['visibility'],
				'type_id'		=> $validated['type']
			]);
		} catch (\Exception $e) {
			return response()->json([
				'error' => true, 'message' => 'Update failed. DB is busy or unique constraints failed.'
			]);
		}

		return response()->json([
			'error' => false,
			'message' => 'Entry updated!',
			'data' => [
				'entry' => $entry
			]
		]);
    }

    /**
     * Remove the specified resource from storage.
	 * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $this->validate($request, [
					'id'		=> 'required|integer',
				]);
		$entry = Auth::user()->entries()->find($request->id);

		if ($entry) {
			$entry->delete();

			return response()->json([
					'error' => false,
					'message' => 'Entry removed',
					'data' => []
				]);
		}

		return response()->json([
			'error' => true, 'message' => 'Entry not found!'
		]);
    }
}
