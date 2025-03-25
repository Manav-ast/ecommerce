<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Log;
use App\Models\StaticBlock;

class HomepageController extends Controller
{
    public function index()
    {
        try {
            $categories = Category::latest()->paginate(3);
            return view("pages.home", compact('categories'));
        } catch (\Exception $e) {
            Log::error("Error fetching categories for homepage: " . $e->getMessage());
            return back()->with('error', 'Something went wrong while loading the homepage.');
        }
    }
}
