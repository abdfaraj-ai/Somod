<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\EvacuationBlock;
use App\Models\EvacuationStatus;

class FrontendController extends Controller
{
    public function sos()
    {
        return view('sos');
    }

    public function submitSos(Request $request)
    {
        // Honeypot for bots
        if ($request->filled('robot_check')) {
            return back()->with('error', 'Spam detected.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'detailed_address' => 'required|string',
            'description' => 'required|string',
        ]);

        $validated['status'] = 'pending';

        $call = \App\Models\DistressCall::create($validated);

        event(new \App\Events\NewDistressCallReceived($call));

        return back()->with('success', 'تم استقبال نداء الاستغاثة! فرق الطوارئ ستحاول الوصول إليك في أقرب وقت.');
    }

    public function support()
    {
        $centers = PsychologicalCenter::where('is_active', true)->get();
        return view('frontend.support', compact('centers'));
    }

    public function submitConsultation(Request $request)
    {
        $validated = $request->validate([
            'client_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        PsychologicalConsultation::create($validated);

        return back()->with('success', 'تم استلام طلبك . سنتواصل معك قريباً.');
    }
}
