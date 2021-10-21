<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateProfileRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function update(UpdateProfileRequest $req){
        $user = User::where('email' , $req->email)->select('id')->first();
        $authUser = auth()->user();
        if($user && $user->id !== $authUser->id){
            return redirect()->back()->withInput($req->input)->withErrors(['email' => 'Email exists,Email is unique for all users']); 
        }
        $data = $req->validated();
        $data['password'] = Hash::make($data['password']);
        $update = $authUser->update($data);
        return redirect()->back()->with(['show-message' => [
            'message' => $update ? 'Greate Job' : 'There is a server error try letter',
            'success' => (bool) $update,
        ]]);
    }
}
