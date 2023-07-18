<?php

namespace App\Http\Controllers;

use App\Models\Phrase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PhraseController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phrase' => 'string',
            'author' => 'string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->fails(), 500);
        }


        $record = Phrase::create(
            array_merge(
                ['user_id' => auth()->user()->id,],
                $validator->validated()
            )
        );

        return response()->json($record);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user_id = auth()->user()->id;

        $rows = Phrase::where('user_id', $user_id)
            ->get();

        return response()->json($rows);
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
        $validator = Validator::make($request->all(), [
            'phrase' => 'string',
            'author' => 'string',
        ]);

        $user_id = auth()->user()->id;
        $record = Phrase::find($id);
        if($record->user_id == $user_id) {
            $record->update($validator->validated());
        }

        return response()->json($record);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $record = Phrase::find($id);
        $record->delete();

        return response()->json('OK');
    }

    public function getRandom(Request $request)
    {
        $user_id = auth()->user()->id;

        $row = Phrase::where('user_id', $user_id)
            ->inRandomOrder()->first();

        return response()->json($row);
    }
}
