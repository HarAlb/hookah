<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Models\Order;
use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class TablesController extends Controller
{
    private string $viewPath;

    public function __construct()
    {
        $this->viewPath = 'admin.table';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tables = Table::with('orders.productShort.currencyShort')->orderBy('closed')->get();
        $products = [];
        $tables->map(function ($v) use (&$products){
            if(!$v->orders->isEmpty()){ 
                $v->orders->map(function ($order) use (&$products, $v){
                    $product = ['product' => $order->productShort, 'count' => $order->count, 'orderId'=> $order->id];
                    if(isset($products[$v->id])){
                        $products[$v->id][] = $product;
                    }else{
                        $products[$v->id] = [$product];
                    }
                });
            }
        });
        return view($this->viewPath . '/index', compact('tables','products')); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
        $index = 0;
        if($request->id){
            $index = (int) $request->id;
        }else{
            if($lastIndex = Table::orderByDesc('index')->limit(1)->first()){
                $index = $lastIndex->index;
            }
            ++$index;
        }
        return ['success' => Table::create([
            'id' => $index,
            'path' => Str::random(80),
            'index' => $index
        ])];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleted = Table::where([
            ['closed', '=', 1]
        ])->orderByDesc('id')->limit(1)->get(['id'])->first();
        
        if($deleted){
            $deleted->delete();
        }
        return [
            'message' => $deleted ? 'Greate Job' : 'There is a server error try letter',
            'success' => (bool) $deleted,
            'id' => $deleted->id ?? 0
        ];
    }

    public function bill(Request $req){
        if($req->one || $req->delete){
            $order = Order::where([
                ['id', '=', $req->order],
                ['product_id', '=', $req->product],
            ])->get(['id','count']);
            if($order = $order->first()){
                if($order->count == 1){
                    $order->delete();
                    return response()->json(['success' => true, 'deleted' => true]);
                }else{
                    $order->update([
                        'count' => --$order->count
                    ]);
                    return response()->json(['success' => true, 'decremented' => true]);
                }
            }
        }
        if($req->table_id){
            $tableId = Table::where([
                ['id', '=', $req->table_id]
            ])->limit(1)->get(['id'])->first();
            if(!$tableId){
                return response()->json(['success' => false]);
            }
            $tableId = $tableId->id;
            Order::where([
                ['table_id', '=', $tableId],
            ])->delete();
            if($req->close){
                Table::where('id', $tableId)->update([
                    'closed' => true,
                    'path' => Str::random(80)
                ]);
                return response()->json(['success' => true, 'closeTable' => true]);
            }
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false]);
    }
}
