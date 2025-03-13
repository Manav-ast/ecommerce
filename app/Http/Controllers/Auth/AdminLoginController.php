<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    public function index() {
        return view("auth.admin.login");
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

        }
    }

   
    public function logout() {
        Auth::guard("admin")->logout();
        return redirect(route("admin.login"));
    }
}
