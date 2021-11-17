<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\CreateUpdateProduct;
use App\Models\Category;
use App\Models\CategoryProduct;
use App\Models\Currency;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Image;

class ProductController extends Controller
{
    private string $viewPath;

    public function __construct()
    {
        $this->viewPath = 'admin.product';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $products = Product::query();
        $categories = Category::all(['id','name']);
        if($search = $req->search){
            $products->where([
                ['title', 'like' , '%' . $search . '%'],
                ['desc', 'like' , '%' . $search . '%'],
                ['slug', 'like' , '%' . $search . '%'],
            ]);
        }

        $orderList = [
            'Position',
            'Title',
            'Price'
        ];

        if($categoryId = $req->category_id){
            $products->whereHas('categories', function ($q) use ($categoryId){
                $q->where('categories.id', $categoryId);
            });
        }

        $sortAsc = true;
        if($req->has('sort')){
            $sortAsc = $req->sort; 
        }
        $orderBy = $req->orderBy;
        if(!$orderBy){
            $orderBy = 'position';
        }
        if($sortAsc){
            $products->orderBy($orderBy);
        }else{
            $products->orderByDesc($orderBy);
        }
        $listProducts = $products->with('categories','currency')->paginate(25);
        
        return view($this->viewPath . '/index')->with(compact('orderList','listProducts','categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all(['id','name']);
        $currencies = Currency::all('id','name');
        $create = true;
        $lastPosition = 0;
        if($lastProductPosition = Product::orderByDesc('position')->limit(1)->get(['position'])->first()){
            $lastPosition = $lastProductPosition->position;
        }
        $lastPosition += 1;
        return view($this->viewPath . '/create-update')->with(compact('categories','create','currencies','lastPosition'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\Admin\Product\CreateUpdateProduct  $req
     * @return \Illuminate\Http\Response
     */
    public function store(CreateUpdateProduct $req)
    {
        $slug = Str::slug($req->title);
        $i = 1;
        while(Product::where('slug', $slug)->get(['id'])->first()){
            $slug = Str::slug($req->title) . '_' . $i;
            $i++;
        } 
        $existsPosition = Product::where('position', $req->position)->limit(1)->get(['id','position'])->first();
        if($existsPosition)
        {
            $lastPosition = 0;
            if($lastProductPosition = Product::orderByDesc('position')->limit(1)->get(['position'])->first()){
                $lastPosition = $lastProductPosition->position;
            }
            $lastPosition += 1;
            $existsPosition->update([
                'position' => $lastPosition
            ]); 
        }
        $fileName = $slug. '.' . $req->thumbnail->extension();
        $img = Image::make($req->thumbnail)->resize(320, 240, function ($constraint) {
		    $constraint->aspectRatio();
		});
        $img->save(public_path('uploads/products/' . $fileName));
        $product = Product::create(array_merge($req->validated(), ['thumbnail' => $fileName ,'user_id' => auth()->user()->id,'slug' => $slug]));
        if($product){
            CategoryProduct::create([
                'category_id' => $req->category_id,
                'product_id' => $product->id
            ]);
            return redirect(route('products.index'))->with([
                'show-message' => [
                    'message' => 'Great Job',
                    'success' => true,
                ]]);
        }
        return redirect()->back()->with([
            'show-message' => [
                'message' => 'There is a server error try letter',
                'success' => false,
            ]]);
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
        $product = Product::findOrFail($id);
        $product->with('category','currency')->get();
        $categories = Category::all(['id','name']);
        $currencies = Currency::all('id','name');
        $create = false;
        return view($this->viewPath . '/create-update')->with(compact('categories','product','create','currencies'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CreateUpdateProduct $req, $id)
    {
        /** @var ?Product */
        $product = Product::findOrFail($id);
        DB::beginTransaction();
        
        try{
            if($product->title != $req->title){
                $slug = Str::slug($req->title);
                $i = 1;
                while(Product::where('slug', $slug)->get(['id'])->first()){
                    $slug = Str::slug($req->title) . '_' . $i;
                    $i++;
                }
            }else{
                $slug = $product->slug;
            }
            if($req->thumbnail){
                $fileName = $slug  . '.' . $req->thumbnail->extension(); 
                $req->thumbnail->move(public_path('uploads/products'), $fileName);
            }
            
            $product->update(array_merge($req->validated(), [
                'thumbnail' => isset($fileName) ? $fileName : $product->thumbnail,
                'slug' => $slug
            ]));

            CategoryProduct::where('product_id', $id)->delete();
            CategoryProduct::create([
                'category_id' => $req->category_id,
                'product_id' => $id
            ]);
            DB::commit();
            return redirect(route('products.index'))->with([
                'show-message' => [
                    'message' => 'Great Job',
                    'success' => true,
                ]]);
        }catch(\Exception $e){
            DB::rollback();
            return redirect()->back()->with([
                'show-message' => [
                    'message' => 'There is a server error try letter',
                    'success' => false,
                ]]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $toDelete = Product::findOrFail($id);
        DB::beginTransaction();
        try{
            CategoryProduct::where('product_id', $id)->delete();
            $toDelete->delete();
            DB::commit();
            return [
                'message' => 'Greate Job',
                'success' => true,
            ];
        }catch(\Exception $e){
            DB::rollback();
            return [
                'message' => 'There is a server error try letter',
                'success' => false,
            ];
        }   
    }
}
