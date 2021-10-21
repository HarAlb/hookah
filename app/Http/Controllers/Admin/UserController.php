<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\CreateUpdateUserRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    private string $viewPath;

    public function __construct()
    {
        $this->viewPath = 'admin.user';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $users = User::where(function ($q){
            $q->whereNull('is_admin')
                ->orWhere('is_admin', '<>', true);
        });
        if($search = $req->search){
            $users->where(function ($q) use ($search){
                $q->where('email', 'like', '%' . $search . '%')
                    ->orWhere('name', 'like', '%' . $search . '%');
            });
        }
        // dd($users->get());
        $countUsers = $users->count('id');
        $listUsers = $users->paginate();
        return view($this->viewPath .'/index')->with(compact('listUsers', 'countUsers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view($this->viewPath . '/create-update');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateUpdateUserRequest $req)
    {
        $existsEmail = User::where('email', $req->email)->limit(1)->get(['id'])->first();
        if($existsEmail){
            return redirect()->back()->withInput($req->input)->withErrors(['email' => 'Email exists,Email is unique for all users']); 
        }
        $created = User::create(array_merge($req->validated(), ['password' => Hash::make($req->password)]));
        return redirect(route('users.index'))->with([
            'show-message' => [
                'message' => $created ? 'Greate Job' : 'There is a server error try letter',
                'success' => (bool) $created,
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
        return view($this->viewPath . '/create-update')->with(['user' => User::find($id)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\Admin\User\CreateUpdateUserRequest  $req
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CreateUpdateUserRequest $req, $id)
    {
        $user = User::findOrFail($id);
        $updated = $user->update(array_merge($req->validated(), ['password' => Hash::make($req->password)]));
        return redirect(route('users.index'))->with([
            'show-message' => [
                'message' => $updated ? 'User successfully updated' : 'There is a server error try letter',
                'success' => (bool) $updated,
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
        $deleted = User::find($id)->delete();
        return [
                'message' => $deleted ? 'Greate Job' : 'There is a server error try letter',
                'success' => (bool) $deleted,
        ];
    }
}
