<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Auth;

class AuthController extends Controller
{
    public function login(LoginRequest $req){
        $user = User::where('email' , $req->email)->select('id' , 'password', 'is_admin')->first();
        if(Hash::check($req->password, $user->password)){
            Auth::login($user);
            if($user->is_admin){
                return redirect()->intended();
            }
            return redirect('/');
        }
        return redirect('auth/login')->withErrors(['password' => 'Password is not right'])->withInput($req->input());
    }

    public function logout(Request $req){
        Auth::logout();

        $req->session()->invalidate();

        $req->session()->regenerateToken();

        return redirect(route('login'));
    }
}
