<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
class UserController extends Controller
{
    /**
     * Create an Admin User
     */
    public function createAdmin(){
        $existing = User::where('role', 'admin')->first();
        if ($existing) {
            return "Admin already exists: " . $existing->email;
        }

        $admin = User::create([
            'name' => 'Super Admin',
            'email' => 'admin@example.com',
            'country_code' => '+91',
            'mobile' => '9876543210',
            'password' => 'password123', 
            'location' => 'Head Office',
            'role' => 'admin',
            'status' => 'active',
            'email_verified' => true,
            'logged_in' => false,
        ]);

        return "Admin created successfully: " . $admin->email;
    }

    public function createPartner(){
        $existing = User::where('role', 'partner')->first();
        if ($existing) {
            return "Partner already exists: " . $existing->email;
        }

        $partner = User::create([
            'name' => 'Partner User',
            'email' => 'partner@example.com',
            'country_code' => '+91',
            'mobile' => '9875543210',
            'password' => 'password123', 
            'location' => 'Head Office',
            'role' => 'partner',
            'status' => 'active',
            'email_verified' => true,
            'logged_in' => false,
        ]);

        return "Partner created successfully: " . $partner->email;
    }

    public function showLogin(){
        return view('auth.login');
    }

    public function login(Request $request){
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
            'role'     => 'required|string',
        ]);

        $user = User::where('email', $request->email)
                    ->where('role', $request->role)
                    ->first();

        if (!$user) {
            return back()->withErrors(['email' => 'No user found with this email and role'])->withInput();
        }

        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'Incorrect password'])->withInput();
        }

        if ($user->status !== 'active') {
            return back()->withErrors(['status' => 'Your account is ' . $user->status])->withInput();
        }

        $user->update(['logged_in' => true]);

        Session::put('auth_user', $user);

        switch ($user->role) {
            case 'admin':
                return redirect('/admin/dashboard');
            case 'partner':
                return redirect('/partner/dashboard');
            case 'supplier':
                return redirect('/supplier/dashboard');
            case 'employee':
                return redirect('/employee/dashboard');
            default:
                return redirect('/dashboard'); // customer
        }
    }

    public function logout(){
        $user = Session::get('auth_user');
        if ($user) {
            User::where('id', $user->id)->update(['logged_in' => false]);
        }

        Session::forget('auth_user');
        return redirect()->route('login')->with('success', 'Logged out successfully');
    }


}
