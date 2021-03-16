<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class AuthLogout extends Controller
{
    public function logout(Request $request){
        $request->session()->flush();
        Auth::logout();
        return Redirect::to('/login')->with('status', 'Successfully logged out.');
    }
}
