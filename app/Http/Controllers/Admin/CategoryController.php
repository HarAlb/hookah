<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Category\CreateUpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Support\Str;
use PHPUnit\Util\Json;

class CategoryController extends Controller
{
    private string $viewPath;

    public function __construct()
    {
        $this->viewPath = 'admin.category';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::orderBy('parent_id')->withCount('products')->get();
        // dd($_COOKIE, \Cookie::get('is_italian'));
        return view($this->viewPath . '/index')
            ->with([
                'categories' => $categories,
                'count' => $categories->count('id')
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view($this->viewPath . '/create-update')
            ->with([
                // 'categories' => Category::all(['id','name']),
                'create' => true
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Admin\Category\CreateUpdateCategoryRequest  $req
     * @return \Illuminate\Http\Response
     */
    public function store(CreateUpdateCategoryRequest $req)
    {
        $slug = Str::slug($req->name);
        $i = 1;
        while(Category::where('slug', $slug)->get(['id'])->first()){
            $slug = Str::slug($req->title) . '_' . $i;
            $i++;
        }
        /** @var Category $createdCategory */
        $createdCategory = Category::create([
            'name' => $req->name,
            'parent_id' => (int) ($req->parent_id ?? 0),
            'slug' => $slug
        ]);
        if($createdCategory){
            return redirect(route('categories.index'))->with([
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
        $category = Category::where('id', $id)->with('translations')->first();
        abort_if(!$category, 404);
        return view($this->viewPath . '/create-update')->with([
            'category' => $category,
            'create' => false
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\Admin\Category\CreateUpdateCategoryRequest  $req
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CreateUpdateCategoryRequest $req, $id)
    {
        $category = Category::where('id', $id)->first();
        abort_if(!$category, 404);
        \DB::beginTransaction();

        try{
            $category->update($req->validated());            
        }catch(\Exception $e){
            \DB::rollback();
            return redirect(route('categories.index'))->with([
                'show-message' => [
                    'message' => 'There is a server error try letter',
                    'success' => true,
                ]
            ]);
        }
        \DB::commit();
        return redirect(route('categories.index'))->with([
            'show-message' => [
                'message' => 'Category successfully updated',
                'success' => true,
            ]]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleted = Category::find($id);
        $deleted->removeTranslates();
        $deleted->delete();
        return [
            'message' => $deleted ? 'Greate Job' : 'There is a server error try letter',
            'success' => (bool) $deleted,
        ];
    }
}
