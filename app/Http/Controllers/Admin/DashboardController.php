<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function index() {
        try {
            return view("admin.dashboard");
        } catch (\Exception $e) {
            Log::error("Error loading dashboard: " . $e->getMessage());
            return back()->with('error', 'Something went wrong while loading the dashboard.');
        }
    }
}
