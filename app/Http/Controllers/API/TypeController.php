<?php

namespace App\Http\Controllers\API;

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
			return redirect()->route('user-options', [ 'user' => $user->name ]);
		}

		Type::create([
			'user_id'	=> $user->id,
			'name'		=> $request->name,
			'ident_1'	=> $request->ident_1,
			'ident_2'	=> $request->ident_2,
            'display'	=> $request->display,
		]);

		return redirect()->route('user-options', [ 'user' => $user->name ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function show(Type $type)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Type $type)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string				$userName
     * @param  \App\Models\Type		$type
     * @return \Illuminate\Http\Response
     */
    public function destroy(string $userName, Type $type)
    {
        $b = $type->delete();

		return redirect()->route('user-options', [ 'user' => Auth::user()->name ]);
    }
}
