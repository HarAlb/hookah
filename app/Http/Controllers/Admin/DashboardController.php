<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard(){
        return view('admin.dashboard');
    }

    public function setCookie(Request $req)
    {
        cookie()->queue($req->name , $req->value , 24 * 365 * 60);
        return ['success' => true];
    }
}
