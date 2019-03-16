<?php

namespace Gajo\Http\Controllers;

use Gajo\Type;
use Illuminate\Http\Request;

class TypeController extends Controller {
    public function store(Request $request) {
        $data = $this->validate($request, [
            'name' => 'required|string|min:1',
            'ident_1' => 'required|string|min:1',
            'ident_2' => 'required|string|min:1',
            'display' => 'required|integer|min:1|max:2',
            'sort' => 'required|integer|min:0'
        ]);

        try {
            $user = \Auth::user();
            $type = \Gajo\Type::firstOrCreate([
                'name' => e($data['name']),
                'ident_1' => e($data['ident_1']),
                'ident_2' => e($data['ident_2']),
                'user_id' => $user->id
            ]);
            $type->display = $data['display'];
            $type->sort = $data['sort'];
            $type->save();
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ]);
        }

        return response()->json([
            'error' => false,
            'data' => $type->id
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request) {
        $data = $this->validate($request, [
            'id'        => 'required|integer',

            'name'      => 'required|string|min:2',
            'ident_1'   => 'required|string|min:1',
            'ident_2'   => 'required|string|min:1',

            'sort'      => 'required|integer|min:0',
            'display'   => 'required|integer',
        ]);

        $user = \Auth::user();
        $type = \Gajo\Type::where([ 'id' => $data['id'], 'user_id' => $user->id ])->firstOrFail();
        $type->name = $data['name'];
        $type->ident_1 = $data['ident_1'];
        $type->ident_2 = $data['ident_2'];
        $type->sort = $data['sort'];
        $type->display = $data['display'];
        $type->save();
            
        return response()->json([
            'error' => false,
            'data' => $type
        ]);
    }

    public function destroy(Request $request) {
        $data = $this->validate($request, [
            'id' => 'required|integer|min:1',
            // refreshTypeOrder has its own API endpoint and therefore needs a Request
            // but we won't allow the deletion of types without this info in the first place
            'types.*.id' => 'required|integer|min:1',
			'types.*.pos' => 'required|integer|min:0',
        ]);

        try {
            $user = \Auth::user();
            $type = \Gajo\Type::where('user_id', $user->id)->where('id', $data['id'])->firstOrFail();
            if ($type->entries->count() > 0) {
                throw new \Exception('This type has entries and cannot be removed!');
            }
            $type->delete();
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ]);
        }

        return $this->refreshTypeOrder($request);
    }
    
    public function refreshOrder(Request $request) {
		$data = $this->validate($request, [
			'types.*.id' => 'required|integer|min:1',
			'types.*.pos' => 'required|integer|min:0',
		]);

		try {
			foreach ($data['types'] as $tOrder) {
				$user = \Auth::user();
				$type = \Gajo\Type::where('user_id', $user->id)->where('id', $tOrder['id'])->first();
				if ($type) {
					$type->sort = $tOrder['pos'];
					$type->save();
				}
			}
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
