<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class DuplicateCheckController extends Controller
{
    public function checkEmail(Request $request)
    {
        $email = $request->input('email');
        $exists = User::where('email', $email)->exists();

        return response()->json([
            'available' => !$exists
        ]);
    }

    public function checkPhone(Request $request)
    {
        $phone = $request->input('phone_no');
        $exists = User::where('phone_no', $phone)->exists();

        return response()->json([
            'available' => !$exists
        ]);
    }
}
