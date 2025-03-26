<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PageBlock;
use Illuminate\Support\Facades\Log;

class PageController extends Controller
{
    public function show($slug)
    {
        try{
            $page = PageBlock::where('slug', $slug)->where('status', 'active')->first();
            if ($page) {
                return view('pages.page', compact('page'));
            } else {
                abort(404);
            }
        }
        catch(\Exception $e){
            Log::error($e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while processing your request.');
        }
    }
}
