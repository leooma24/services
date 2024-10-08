<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Movement;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MovementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {


        $user_id = auth()->user()->id;
        $incomes = Movement::where('type', 0)
            ->where('user_id', $user_id)
            ->whereDate('date', '<', Carbon::parse($request->date)->startOfMonth())
            ->sum('amount');

        $liabilities = Movement::where('type', 1)
            ->where('user_id', $user_id)
            ->whereDate('date', '<', Carbon::parse($request->date)->startOfMonth())
            ->sum('amount');

        $items = Category::where('user_id', $user_id)->withSum(['movements' => function($q) use ($request) {
            $q->whereDate('date', '>=', Carbon::parse($request->date)->startOfMonth())
                ->whereDate('date', '<=', Carbon::parse($request->date)->endOfMonth() );
        }], 'amount')
            ->withCount(['movements' => function($q) use ($request) {
                $q->whereDate('date', '>=', Carbon::parse($request->date)->startOfMonth())
                    ->whereDate('date', '<=', Carbon::parse($request->date)->endOfMonth() );
            }], 'count')
            ->orderBy('movements_sum_amount', 'desc')
            ->get()
            ->transform(function($item) use($request, $user_id) {
                $lastDate = Carbon::parse($request->date)->subMonth();
                $item->last = Movement::where('type', $item->type)
                    ->where('category_id', $item->id)
                    ->where('user_id', $user_id)
                    ->whereDate('date', '>=', $lastDate->startOfMonth())
                    ->whereDate('date', '<=', $lastDate->endOfMonth())
                    ->sum('amount');
                $item->count = Movement::where('type', $item->type)
                    ->where('category_id', $item->id)
                    ->where('user_id', $user_id)
                    ->whereDate('date', '>=', $lastDate->startOfMonth())
                    ->whereDate('date', '<=', $lastDate->endOfMonth())
                    ->count();
                return $item;
            })
            ->toArray();

        return response()->json([
            'incomes' => $incomes,
            'liabilities' => $liabilities,
            'last' => $incomes - $liabilities,
            'records' => $items
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'date' => 'required|date',
            'amount' => 'required|numeric',
            'title' => 'string',
            'category_id.id' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->fails(), 500);
        }

        // = $validator->validated();
        $category = Category::find($request->category_id['id']);
        $paid = null;
        if(isset($request->paid_id['id'])) {
            $paid = Category::find($request->paid_id['id']);
            Movement::create(
                array_merge(
                    [
                        'user_id' => auth()->user()->id,
                        'category_id' => $paid->id,
                        'type' => $paid->type,
                        'paid_id' => 0,
                    ],
                    $request->except(['category_id', 'paid_id'])
                )
            );
        }
        $record = Movement::create(
            array_merge(
                [
                    'user_id' => auth()->user()->id,
                    'category_id' => $category->id,
                    'type' => $category->type,
                    'paid_id' => $paid->id ?? 0,
                ],
                $request->except(['category_id', 'paid_id'])
            )
        );

        return response()->json($record);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'date' => 'required|date',
            'amount' => 'required|numeric',
            'title' => 'string',
            'category_id.id' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->fails(), 500);
        }
        $record = Movement::where('user_id', auth()->user()->id)
            ->where('id', $id);
        if(!$record) {
            return response()->json(['msg' => 'No se encontro el registro o no te pertecene.'], 500);
        }
        $category = Category::find($request->category_id['id']);
        $record->update(array_merge(
            [
                'category_id' => $category->id,
            ],
            $request->except(['category_id', 'paid_id'])
        ));

        return response()->json($record);
    }

    public function getMovements(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'date' => 'required|date',
            'category_id' => 'integer'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->fails(), 500);
        }

        $records = Movement::where('category_id', $request->category_id)
            ->with('category')
            ->where('user_id', auth()->user()->id)
            ->whereDate('date', '>=', Carbon::parse($request->date)->startOfMonth())
            ->whereDate('date', '<=', Carbon::parse($request->date)->endOfMonth())
            ->orderBy('date', 'desc')
            ->get()
            ->toArray();

        return response()->json(empty($records) ? [] : $records);
    }

    public function getMovementsByType(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'date' => 'required|date',
            'type' => 'integer'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->fails(), 500);
        }

        $records = Movement::where('type', $request->type)
            ->with('category')
            ->where('user_id', auth()->user()->id)
            ->whereDate('date', '>=', Carbon::parse($request->date)->startOfMonth())
            ->whereDate('date', '<=', Carbon::parse($request->date)->endOfMonth())
            ->orderBy('date', 'desc')
            ->get()
            ->toArray();

        return response()->json(empty($records) ? [] : $records);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $record = Movement::find($id);
        $record->delete();

        return response()->json('OK');
    }
}
