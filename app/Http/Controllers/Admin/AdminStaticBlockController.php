<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StaticBlock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Http\Requests\Admin\StaticBlockRequest;

class AdminStaticBlockController extends Controller
{
    /**
     * Display a listing of the static blocks.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $staticBlocks = StaticBlock::orderBy('id', 'desc')->paginate(8);
        return view('admin.static_blocks.index', compact('staticBlocks'));
    }

    /**
     * Show the form for creating a new static block.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.static_blocks.create');
    }

    /**
     * Store a newly created static block in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StaticBlockRequest $request)
    {
        try {
            StaticBlock::create($request->validated());

            return redirect()->route('admin.static_blocks.index')
                ->with('success', 'Static block created successfully.');
        } catch (\Exception $e) {
            Log::error('Static Block Creation Error: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Error creating static block. Check logs for details.')
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
        $staticBlock = StaticBlock::findOrFail($id);
        return view('admin.static_blocks.edit', compact('staticBlock'));
    }

    /**
     * Update the specified static block in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StaticBlockRequest $request, $id)
    {
        try {
            $staticBlock = StaticBlock::findOrFail($id);
            $staticBlock->update($request->validated());

            return redirect()->route('admin.static_blocks.index')
                ->with('success', 'Static block updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error updating static block: ' . $e->getMessage())
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
            $staticBlock = StaticBlock::findOrFail($id);
            $staticBlock->delete();

            return response()->json([
                'success' => true,
                'message' => 'Static block deleted successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting static block: ' . $e->getMessage()
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

        $staticBlocks = StaticBlock::where('title', 'like', '%' . $search . '%')
            ->orWhere('slug', 'like', '%' . $search . '%')
            ->orderBy('id', 'desc')
            ->get(); // Get all results instead of paginate for AJAX

        $desktopHtml = view('admin.static_blocks.partials.table', compact('staticBlocks'))->render();
        $mobileHtml = view('admin.static_blocks.partials.mobile', compact('staticBlocks'))->render();

        return response()->json([
            'html' => $desktopHtml,
            'mobileHtml' => $mobileHtml
        ]);
    }
}
