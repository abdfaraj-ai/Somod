<?php

namespace App\Http\Controllers;

use App\Models\EvacuationMap;
use Illuminate\Http\Request;

class EvacuationController extends Controller
{
    public function index(Request $request)
    {
        $area = $request->get('area', 'all');
        
        $query = EvacuationMap::query();
        
        if ($area !== 'all') {
            $query->where('area', $area);
        }
        
        $blocks = $query->orderBy('block_number')->get();
        
        $stats = [
            'total' => EvacuationMap::count(),
            'safe' => EvacuationMap::where('status', 'safe')->count(),
            'warning' => EvacuationMap::where('status', 'warning')->count(),
            'danger' => EvacuationMap::where('status', 'danger')->count(),
            'evacuation' => EvacuationMap::where('status', 'evacuation')->count(),
        ];
        
        $areas = EvacuationMap::select('area')->distinct()->get()->pluck('area')->toArray();
        
        $alerts = EvacuationMap::whereIn('status', ['danger', 'evacuation'])
            ->orderBy('last_updated', 'desc')
            ->limit(5)
            ->get();
        
        return view('evacuation.index', compact('blocks', 'stats', 'areas', 'area', 'alerts'));
    }

    public function search(Request $request)
    {
        $request->validate([
            'block_number' => 'required|string'
        ]);
        
        $block = EvacuationMap::where('block_number', $request->block_number)->first();
        
        if (!$block) {
            return back()->with('error', 'لم يتم العثور على البلوك المطلوب');
        }
        
        return redirect()->route('evacuation.show', $block->id);
    }

    public function show($id)
    {
        $block = EvacuationMap::findOrFail($id);
        
        $neighborBlocks = EvacuationMap::where('area', $block->area)
            ->where('id', '!=', $block->id)
            ->limit(4)
            ->get();
        
        return view('evacuation.show', compact('block', 'neighborBlocks'));
    }

    public function updateStatus(Request $request, $id)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }
        
        $block = EvacuationMap::findOrFail($id);
        
        $request->validate([
            'status' => 'required|in:safe,warning,danger,evacuation',
            'description' => 'nullable|string|max:500'
        ]);
        
        $block->update([
            'status' => $request->status,
            'description' => $request->description,
            'update_source' => 'community',
            'last_updated' => now()
        ]);
        
        return back()->with('success', 'تم تحديث حالة البلوك بنجاح');
    }

    public function getMapData()
    {
        $blocks = EvacuationMap::select(
            'id', 
            'block_number', 
            'area', 
            'status',
            'coordinates',
            'description'
        )->get();
        
        return response()->json($blocks);
    }
}