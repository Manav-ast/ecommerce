<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Show login page
    public function index()
    {
        try {
            return view("pages.auth.login");
        } catch (Exception $e) {
            return back()->with('error', 'Something went wrong while loading the login page.');
        }
    }

    // Authenticate user
    public function authenticate(AuthRequest $request)
    {
        try {
            $credentials = $request->only(["email", "password"]);

            // Attempt to login
            if (Auth::guard("user")->attempt($credentials)) {
                $user = Auth::guard("user")->user(); // Get logged-in user

                // Check if user is active
                if ($user->status !== "active") {
                    Auth::guard("user")->logout(); // Logout inactive user
                    return back()->withErrors([
                        'email' => 'Your account is inactive. Please contact support.'
                    ])->onlyInput('email');
                }

                $request->session()->regenerate();
                return redirect(route("home"));
            }

            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])->onlyInput('email');
        } catch (Exception $e) {
            return back()->with('error', 'Something went wrong while logging in.');
        }
    }

    // Logout user
    public function logout()
    {
        try {
            Auth::guard("user")->logout();
            return redirect(route("user.login"))->with('success', 'You have been logged out.');
        } catch (Exception $e) {
            return back()->with('error', 'Something went wrong while logging out.');
        }
    }
}
