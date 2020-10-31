<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Type;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TypeController extends Controller
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
        $this->validate($request, [
			'name'		=> 'required|string',
			'ident_1'	=> 'required|string',
			'ident_2'	=> 'required|string',
            'display'	=> 'required|integer',
        ]);

		$user = Auth::user();
		$type = Type::whereName($request->name)->where('user_id', $user->id)->first();
		if ($type) {
			return response()->json([
				'error' => true, 'message' => 'Type exists already!'
			]);
		}

		$type = Type::create([
			'user_id'	=> $user->id,
			'name'		=> $request->name,
			'ident_1'	=> $request->ident_1,
			'ident_2'	=> $request->ident_2,
            'display'	=> $request->display,
			'sort'		=> Type::count()+1,
		]);

		return response()->json([
			'error' => false, 'message' => 'Type added!', 'data' => $type
		]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
	{
        $this->validate($request, [
			'id'		=> 'required|integer',
			'name'		=> 'required|string',
			'ident_1'	=> 'required|string',
			'ident_2'	=> 'required|string',
            'display'	=> 'required|integer',
        ]);

		$user = Auth::user();
		$type = Type::whereId($request->id)->where('user_id', $user->id)->first();
		if (!$type) {
			return response()->json([
				'error' => true, 'message' => 'Type does not exist!'
			]);
		}

		try {
			$type = $type->update([
				'name'		=> $request->name,
				'ident_1'	=> $request->ident_1,
				'ident_2'	=> $request->ident_2,
				'display'	=> $request->display,
			]);
		} catch (\Exception $e) {
			return response()->json([
				'error' => true, 'message' => 'Update failed. DB is busy or unique constraints failed.'
			]);
		}

		return response()->json([
			'error' => false, 'message' => 'Type updated!'
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
		$type = Auth::user()->types()->find($request->id);

		if ($type) {
			$type->delete();

			return response()->json([
					'error' => false,
					'message' => 'Type removed',
					'data' => []
				]);
		}

		return response()->json([
			'error' => true, 'message' => 'Type not found!'
		]);
    }

	/**
     * Reorders the user's types.
	 * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function order(Request $request)
    {
		$this->validate($request, [
			'order'	=> 'required|array'
        ]);

		$order = $request->order;
		if (Auth::user()->types->count() != count($order)) {
			return response()->json([
					'error' => true, 'message' => 'Missing Types to update order.'
				]);
		}

		$mapOrder = [];
		foreach ($order as $index => $id) {
			$mapOrder[$id] = $index;
		}

		$types = Auth::user()->types;
		foreach ($types as $type) {
			$type->update([ 'sort' => $mapOrder[$type->id] ]);
		}
		
		return response()->json([
				'error' => false, 'message' => 'Types reorderd!'
			]);
    }
}
