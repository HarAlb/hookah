<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Http\Requests\ProductsRequest;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\Table;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except('products');
        $this->middleware('exists_qr_or_auth')->only('products');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $req)
    {
        $user = auth()->user();
        $tables = [];
        if(session('log-with-qr')){
            session('pin-exists', false);
        }
        if(session('pin-exists')){
            $tables = Table::orderBy('index')->get();
        }

        return view('dashboard', compact('tables', 'user'));
    }

    public function checkPin(Request $req)
    {   
        if($req->pin == auth()->user()->pin)
        {
            session(['pin-exists' => true]);
            $tables = Table::where('closed',1)->orderBy('index')->get();
            return ['success' => view('components/dashboard-tables', compact('tables'))->render()];
        }
        return ['success' => false];
    }

    public function removePin(){
        session(['pin-exists' => false]);
    }

    public function products(ProductsRequest $req)
    {
        // session(['pin-exists' => false]);
        if($req->qr_code){
            $table = Table::whereRaw('MD5(path) = ?', [$req->qr_code])->get()->first();
            $user = User::whereNull('is_admin')->limit(1)->get(['id'])->first();
            session('log-with-qr', true);
            if($user){
                Auth::loginUsingId($user->id);
            }
        }else{
            $table = Table::where('path', $req->path)->limit(1)->get(['id', 'closed'])->first();
        }
        if(!$table){
            return redirect('/');
        }
        if($table->closed){
            $table->update([
                'closed' => 0
            ]);
        }
        $categories = Category::with('products')->get(['id', 'name', 'slug']);
        $orders = Order::where('table_id', $table->id)->get(['id', 'count']);

        return view('products', compact('categories', 'table', 'orders'));
    }

    public function cancelTableClosing(ProductsRequest $req)
    {
        return redirect('/');
    }

    public function order(OrderRequest $req)
    {
        $isClosedTable = Table::where([
            ['closed','=', 0],
            ['id', '=', $req->table]
        ])->limit(1)->get();
        if(!$isClosedTable->first()){
            Order::where('table_id',$req->table)->delete();
            return response()->json(['success' => false]);
        }
        $productIds = Product::get(['id'])->pluck('id')->toArray();
        $orders = [];
        $crDate = date('Y-m-d H:i:s');
        foreach($req->orders as $value){
            if(in_array((int)$value['id'], $productIds)){
                $orders[] = [
                    'table_id' => (int) $req->table,
                    'user_id' => auth()->user()->id,
                    'product_id' => (int) $value['id'],
                    'count' => (int) $value['count'], 
                    'created_at' => $crDate,
                    'updated_at' => $crDate,
                ];
            }
        }
        $inserted = Order::insert($orders);
        if($inserted){
            return response()->json(['success' => $inserted]);
        }
    }

    public function setSession(Request $req)
    {
        session('key', 'default');
    }

    public function getOrdersByTableId(Request $req)
    {
        $response = ['success' => false];
        if($req->table_id){
            // check closed table
            $isClosedTable = Table::where([
                ['id', '=', $req->table_id],
                ['closed', '=' , 0]
            ])->limit(1)->get()->first();
            if($isClosedTable){
                return ['success' => true, 'orders' => Order::where([
                        ['table_id', '=', $req->table_id]
                    ])->get(['product_id','count'])];
            }
            $response['message'] = 'Table is opened!';
        }
        return response()->json($response);
    }
}
