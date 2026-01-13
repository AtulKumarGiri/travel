<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Documents;
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

    public function createEmployees(){
        // Check how many employees already exist
        $existing = User::where('role', 'employee')->count();

        if ($existing >= 5) {
            return "Employees already created (" . $existing . ")";
        }

        $employees = [
            ['name' => 'Employee One',   'email' => 'emp1@example.com', 'mobile' => '9876543211'],
            ['name' => 'Employee Two',   'email' => 'emp2@example.com', 'mobile' => '9876543212'],
            ['name' => 'Employee Three', 'email' => 'emp3@example.com', 'mobile' => '9876543213'],
            ['name' => 'Employee Four',  'email' => 'emp4@example.com', 'mobile' => '9876543214'],
            ['name' => 'Employee Five',  'email' => 'emp5@example.com', 'mobile' => '9876543215'],
        ];

        foreach ($employees as $data) {

            // Skip if user already exists
            if (User::where('email', $data['email'])->exists()) {
                continue;
            }

            User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'country_code' => '+91',
                'mobile' => $data['mobile'],
                'password' => bcrypt('password123'),
                'location' => 'Head Office',
                'role' => 'employee',
                'status' => 'active',
                'email_verified' => true,
                'logged_in' => false,
            ]);
        }

        return "5 employees created successfully!";
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

    public function profile(){
        $sessionUser = session('auth_user');

        if (!$sessionUser) {
            return redirect()->route('login');
        }

        $user = \App\Models\User::find($sessionUser->id);

        if (!$user) {
            return redirect()->route('login');
        }

        // Required fields for partner company profile
        $requiredFields = [
            'name',
            'email',
            'mobile',
            'company_name',
            'company_address',
            'city',
            'state',
            'country',
            'pincode',
        ];

        $completed = 0;

        foreach ($requiredFields as $field) {
            if (!empty($user->{$field})) {
                $completed++;
            }
        }

        $total = count($requiredFields);
        $completionPercent = $total > 0 ? round(($completed / $total) * 100) : 0;

        return view('common.profile', compact('user', 'completionPercent'));
    }

    public function updatePassword(Request $request){
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        $user = User::findOrFail(session('auth_user')->id);

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect']);
        }

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return back()->with('success', 'Password updated successfully');
    }

    public function settings(){
        return view('users.settings');
    }

    public function storeDocument(Request $request){
        $request->validate([
            'title' => 'required',
            'body' => 'nullable',
            'type' => 'required',
        ]);

        $creator = session('auth_user')->id;
        
        $document = Documents::create([
            'title'       => $request->title,
            'body'        => $request->body,
            'type'        => $request->type,
            'is_private'  => empty($request->shared_with) ? 1 : 0,
            'created_by'  => $creator,
            'updated_by'  => $creator,
            'status'      => 'active',
        ]);

        if (!empty($request->shared_with)) {
            $document->shareWithUsers($request->shared_with, session('auth_user')->id);
        }

        return response()->json([
            'status' => 'saved',
            'document_id' => $document->id,
            'updated_at' => now(),
        ]);

    }


    public function documentsIndex(){

        $userId = session('auth_user')->id;

        $documents = Documents::where(function($q) use ($userId) {
                $q->where('created_by', $userId);   // created by me
            })
            ->orWhere(function($q) use ($userId) {
                $q->where('is_private', 0)          // is shared
                ->whereJsonContains('shared_with', $userId); // shared with me
            })
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('common.documents.index', compact('documents'));
    }

    public function createDocument(){
        $users = User::where('id', '!=', session('auth_user')->id)->where('role', '=', 'employee')->get();
        return view('common.documents.create', compact('users'));
    }

    public function showDocument($id){
        $document = Documents::find($id);

        if (!$document) {
            return redirect()->route('documents.index')->with('error', 'Document not found');
        }

        return view('common.documents.show', compact('document'));
    }

    public function editDocument($id){
        $document = Documents::with('sharedUsers')->findOrFail($id);

        // Only owner can edit
        if ($document->created_by != session('auth_user')->id) {
            abort(403, 'Unauthorized');
        }

        $users = User::where('id', '!=', session('auth_user')->id)->get();

        return view('common.documents.edit', compact('document', 'users'));
    }

    public function updateDocument(Request $request, $id){
        $document = Documents::findOrFail($id);

        if ($document->created_by != session('auth_user')->id) {
            abort(403, 'Unauthorized');
        }

        $document->update([
            'title'      => $request->title,
            'type'       => $request->type,
            'body'       => $request->body,
            'is_private' => $request->privacy === 'private' ? 1 : 0,
        ]);

        // Update shared users
        if ($request->privacy === 'shared') {
            $document->sharedUsers()->sync($request->shared_with ?: []);
        } else {
            $document->sharedUsers()->detach();
        }

        return redirect()->route('documents.index', $document->id)->with('success', 'Document updated successfully.');
    }


    public function printDocument($id){
        $document = Documents::findOrFail($id);

        $pdf = \PDF::loadView('common.documents.print', compact('document'))
                    ->setPaper('A4', 'portrait');

        return $pdf->download($document->title . '.pdf');
    }






}
