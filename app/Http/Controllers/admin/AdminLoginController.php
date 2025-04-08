<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AdminLoginController extends Controller
{
  public function showLoginForm()
    {
        return view('auth.admin-login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
    
        // Check if the user has the 'admin' role
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // Authentication successful
            $user = Auth::user();

            // Check user role and redirect accordingly
            if ($user->role == 'admin') {
                return response()->json([
                    'success' => true,
                    'message' => 'Login successful!',
                    'redirect' => '/admin/dashboard', // Redirect to Admin dashboard
                ]);
            } 
        } 
    
        throw ValidationException::withMessages([
            'email' => __('auth.failed'),
        ]);
    }
    
    public function logout(Request $request)
    {
        Auth::logout();
         
       // Invalidate the session
       $request->session()->invalidate();
       
       // Regenerate CSRF token
       $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }
}
