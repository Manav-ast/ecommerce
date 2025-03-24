<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StaticBlock;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminStaticBlockController extends Controller
{
    /**
     * Display a listing of the static blocks.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $staticBlocks = StaticBlock::orderBy('id', 'desc')->paginate(10);
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
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:static_blocks,slug',
            'content' => 'required',
            'status' => 'required|in:active,inactive',
        ]);

        try {
            StaticBlock::create([
                'title' => $request->title,
                'slug' => $request->slug,
                'content' => $request->content,
                'status' => $request->status,
            ]);

            return redirect()->route('admin.static_blocks.index')
                ->with('success', 'Static block created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error creating static block: ' . $e->getMessage())
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
    public function update(Request $request, $id)
    {
        $staticBlock = StaticBlock::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:static_blocks,slug,' . $id,
            'content' => 'required',
            'status' => 'required|in:active,inactive',
        ]);

        try {
            $staticBlock->update([
                'title' => $request->title,
                'slug' => $request->slug,
                'content' => $request->content,
                'status' => $request->status,
            ]);

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

            return redirect()->route('admin.static_blocks.index')
                ->with('success', 'Static block deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error deleting static block: ' . $e->getMessage());
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
        $search = $request->get('search');
        $staticBlocks = StaticBlock::where('title', 'like', '%' . $search . '%')
            ->orWhere('slug', 'like', '%' . $search . '%')
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('admin.static_blocks.index', compact('staticBlocks'));
    }
}
