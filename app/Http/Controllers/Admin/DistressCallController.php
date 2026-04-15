<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DistressCall;
use Illuminate\Http\Request;

class DistressCallController extends Controller
{
    public function index()
    {
        $calls = DistressCall::orderByRaw("
            CASE
                WHEN status = 'pending' THEN 1
                WHEN status = 'in_progress' THEN 2
                WHEN status = 'resolved' THEN 3
                WHEN status = 'cancelled' THEN 4
                ELSE 5
            END
        ")->latest()->get();

        return view('admin.distress-calls.index', compact('calls'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:255',
            'detailed_address' => 'required|string',
            'description' => 'required|string',
            'status' => 'required|in:pending,in_progress,resolved,cancelled',
        ]);

        DistressCall::create($validated);

        return redirect()->back();
    }

    public function update(Request $request, DistressCall $distressCall)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'phone_number' => 'sometimes|required|string|max:255',
            'detailed_address' => 'sometimes|required|string',
            'description' => 'sometimes|required|string',
            'status' => 'sometimes|required|in:pending,in_progress,resolved,cancelled',
        ]);

        $distressCall->update($validated);

        return redirect()->back();
    }

    public function destroy(DistressCall $distressCall)
    {
        $distressCall->delete();

        return redirect()->back();
    }
}
