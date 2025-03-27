<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    /**
     * Show login page
     */
    public function index()
    {
        try {
            return view("pages.auth.login");
        } catch (Exception $e) {
            Log::error("Error loading login page: " . $e->getMessage());
            return back()->with('error', 'Something went wrong while loading the login page.');
        }
    }

    /**
     * Authenticate user
     */
    public function authenticate(AuthRequest $request)
    {
        try {
            $credentials = $request->only(["email", "password"]);

            // Attempt to login with user guard
            if (Auth::guard("user")->attempt($credentials)) {
                $user = Auth::guard("user")->user();

                // Check if user is active
                if ($user->status !== "active") {
                    Auth::guard("user")->logout();
                    return back()->withErrors([
                        'email' => 'Your account is inactive. Please contact support.'
                    ])->onlyInput('email');
                }

                $request->session()->regenerate();
                return redirect()->intended(route("home"));
            }

            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])->onlyInput('email');
        } catch (Exception $e) {
            Log::error("Error during authentication: " . $e->getMessage());
            return back()->with('error', 'Something went wrong while logging in.');
        }
    }

    /**
     * Logout user
     */
    public function logout(Request $request)
    {
        try {
            Auth::guard("user")->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route("user.login")->with('success', 'You have been logged out successfully.');
        } catch (Exception $e) {
            Log::error("Error during logout: " . $e->getMessage());
            return back()->with('error', 'Something went wrong while logging out.');
        }
    }
}
