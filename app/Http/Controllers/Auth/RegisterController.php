<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\UserRegisterRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
    /**
     * Show the registration form.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        try {
            return view('auth.user.register');
        } catch (\Exception $e) {
            Log::error("Error loading registration form: " . $e->getMessage());
            return back()->with('error', 'Something went wrong while loading the registration page.');
        }
    }

    /**
     * Handle the registration of a new user.
     *
     * @param  \App\Http\Requests\UserRegisterRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(UserRegisterRequest $request)
    {
        try {
            // Form request handles validation
            $validated = $request->validated();

            // Create the new user
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'phone_no' => $validated['phone_no'] ?? null, // Optional contact number
            ]);

            // Send welcome email
            try {
                Mail::to($user->email)->send(new \App\Mail\WelcomeEmail($user));
            } catch (\Exception $e) {
                Log::error("Failed to send welcome email: " . $e->getMessage());
                // Continue with registration process even if email fails
            }

            // Log the user in after registration
            Auth::login($user);

            // Redirect the user to their dashboard or home page
            return redirect()->route('home');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Let Laravel handle validation errors automatically
            throw $e;
        } catch (\Exception $e) {
            Log::error("Error registering user: " . $e->getMessage());
            return back()->with('error', 'Something went wrong during registration. Please try again.')->withInput();
        }
    }
}
