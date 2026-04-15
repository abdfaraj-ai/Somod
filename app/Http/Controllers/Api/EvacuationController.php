<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\EvacuationBlock;
use App\Models\EvacuationStatus;
use Illuminate\Http\Request;

class EvacuationController extends Controller
{
    // Blocks
    public function indexBlocks()
    {
        $blocks = EvacuationBlock::with('status')->get();
        return response()->json($blocks);
    }

    public function updateBlock(Request $request, EvacuationBlock $block)
    {
        $validated = $request->validate([
            'evacuation_status_id' => 'required|exists:evacuation_statuses,id',
        ]);

        $block->update($validated);

        return response()->json([
            'message' => 'Block updated successfully',
            'block' => $block->load('status')
        ]);
    }

    // Statuses
    public function indexStatuses()
    {
        $statuses = EvacuationStatus::all();
        return response()->json($statuses);
    }

    public function storeStatus(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'color' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $status = EvacuationStatus::create($validated);

        return response()->json($status, 201);
    }

    public function updateStatus(Request $request, EvacuationStatus $status)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'color' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $status->update($validated);

        return response()->json($status);
    }

    public function destroyStatus(EvacuationStatus $status)
    {
        $status->delete();
        return response()->json(['message' => 'Status deleted successfully']);
    }
}
