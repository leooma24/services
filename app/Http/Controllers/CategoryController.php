<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


use App\Models\Category;

class CategoryController extends Controller
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
            'title' => 'string',
            'type' => 'integer',
            'icon' => 'required|string',
            'color' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->fails(), 500);
        }


        $record = Category::create(
            array_merge(
                [
                    'user_id' => auth()->user()->id,
                ],
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

        $categories = Category::where('user_id', $user_id)
            ->where('type', $request->input('type'))->get();

        return response()->json($categories);
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
            'title' => 'string',
            'icon' => 'required|string',
            'color' => 'required|string'
        ]);

        $user_id = auth()->user()->id;
        $record = Category::find($id);
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
        $record = Category::find($id);
        $record->status = 0;
        $record->save();

        return response()->json('OK');
    }


}
