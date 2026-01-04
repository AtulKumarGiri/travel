<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    public function index(){
        $user = Session::get('auth_user');

        if (!$user) {
            return redirect()->route('login')->with('error', 'Please login first.');
        }

        $slug = strtolower($user->role);

        return view('common.dashboard', compact('user', 'slug'));
    }
}
