<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class HomepageController extends Controller
{
    public function index() {
        $categories = Category::all();
        return view("pages.home", compact('categories'));
    }
}
