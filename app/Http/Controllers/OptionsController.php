<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;

class OptionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$user = Auth::user();

        return view('user.options', [
			'user' => $user,
			'types' => $user->types,
			'options' => $user->options,
		]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
		try {
			$data = $this->validate($request, [
				'hideTBA'			=> 'required|boolean',
				'colorblind'		=> 'required|boolean',
				'hideReleased'		=> 'required|boolean',
				'privateProfile'	=> 'required|boolean',
			]);

			$user = Auth::user();
			$userOptions = $user->options;
			$userOptions->update([
				'hideTBA'			=> $data['hideTBA'],
				'colorblind'		=> $data['colorblind'],
				'hideReleased'		=> $data['hideReleased'],
				'privateProfile'	=> $data['privateProfile'],
			]);

			return response()->json([
					'error' => false,
					'data' => [
						'options' => $userOptions
					]
				]);
		} catch (\Exception $e) {
			return response()->json([
				'error' => true,
				'message' => $e->getMessage()
			]);
		}
    }
}
