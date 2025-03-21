<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AdminLoginController extends Controller
{
    public function index() {
        try {
            return view("auth.admin.login");
        } catch (\Exception $e) {
            Log::error("Error loading admin login page: " . $e->getMessage());
            return back()->with('error', 'Something went wrong while loading the login page.');
        }
    }

    public function authenticate(Request $request) {
        try {
            $credentials = $request->only(["email", "password"]);
            
            if(Auth::guard("admin")->attempt($credentials)) {
                $request->session()->regenerate();
                return redirect(route("admin.dashboard"));
            }

            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])->onlyInput('email');

        } catch (Exception $e) {
            Log::error("Error authenticating admin: " . $e->getMessage());
            return back()->with('error', 'Something went wrong while logging in.');
        }
    }

   
    public function logout() {
        try {
            Auth::guard("admin")->logout();
            return redirect(route("admin.login"));
        } catch (\Exception $e) {
            Log::error("Error logging out admin: " . $e->getMessage());
            return back()->with('error', 'Something went wrong while logging out.');
        }
    }
}
