<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PageBlock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Http\Requests\Admin\PageBlockRequest;

class AdminPageBlockController extends Controller
{
    /**
     * Display a listing of the static blocks.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageBlocks = PageBlock::orderBy('id', 'desc')->paginate(8);
        return view('admin.page_block.index', compact('pageBlocks'));
    }

    /**
     * Show the form for creating a new static block.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.page_block.create');
    }

    /**
     * Store a newly created static block in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PageBlockRequest $request)
    {
        try {
            PageBlock::create($request->validated());

            return redirect()->route('admin.page_blocks.index')
                ->with('success', 'Page block created successfully.');
        } catch (\Exception $e) {
            Log::error('Page Block Creation Error: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Error creating page block. Check logs for details.')
                ->withInput();
        }
    }

    /**
     * Show the form for editing the specified static block.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pageBlock = PageBlock::findOrFail($id);
        return view('admin.page_block.edit', compact('pageBlock'));
    }

    /**
     * Update the specified static block in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PageBlockRequest $request, $id)
    {
        try {
            $pageBlock = PageBlock::findOrFail($id);
            $pageBlock->update($request->validated());

            return redirect()->route('admin.page_blocks.index')
                ->with('success', 'Page block updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error updating page block: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified static block from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $pageBlock = PageBlock::findOrFail($id);
            $pageBlock->delete();

            return response()->json([
                'success' => true,
                'message' => 'Page block deleted successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting page block: ' . $e->getMessage()
            ], 500);
        }
    }


    /**
     * Search for static blocks.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $search = $request->get('q');

        $staticBlocks = PageBlock::where('title', 'like', '%' . $search . '%')
            ->orWhere('slug', 'like', '%' . $search . '%')
            ->orderBy('id', 'desc')
            ->get(); // Get all results instead of paginate for AJAX

        $html = view('admin.page_block.partials.table', compact('staticBlocks'))->render();
        $mobileHtml = view('admin.page_block.partials.mobile', compact('staticBlocks'))->render();

        return response()->json([
            'html' => $html,
            'mobileHtml' => $mobileHtml
        ]);
    }
}
