<?php

namespace Gajo\Http\Controllers;

use Gajo\Option;
use Illuminate\Http\Request;

class OptionsController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($user) {
        if (!\Auth::user() || \Auth::user()->name != $user) {
            return redirect()->route('index');
        }
        $user = \Auth::user();
        return view('user-options.index', [
            'user' => $user,
            'options' => $user->options,
            'types' => $user->types()->orderBy('sort')->get()
        ]);
    }

    public function update(Request $request) {
        $data = $this->validate($request, [
            'colorblind_mode' => 'required|boolean',
            'private_profile' => 'required|boolean',
            'list_hide_released' => 'required|boolean',
            'list_hide_tba' => 'required|boolean',
        ]);
        
        $user = \Auth::user();
        $user->options->private = $data['private_profile'];
        $user->options->colorblind = $data['colorblind_mode'];
        $user->options->hideReleased = $data['list_hide_released'];
        $user->options->hideTBA = $data['list_hide_tba'];
        $user->options->save();
    }

    public function refreshRss() {
        $user = \Auth::user();
        $user->options->rss = str_random(42);
        $user->options->save();

        return response()->json([
            'error' => false,
            'data' => $user->options->rss
        ]);
    }
}
