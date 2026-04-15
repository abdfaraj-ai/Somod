<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EvacuationMap;
use Illuminate\Http\Request;

class EvacuationController extends Controller
{
    // عرض قائمة بلوكات الإخلاء
    public function index(Request $request)
    {
        $query = EvacuationMap::query();
        
        // فلترة حسب المنطقة
        if ($request->has('area') && $request->area !== 'all') {
            $query->where('area', $request->area);
        }
        
        // فلترة حسب الحالة
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }
        
        // فلترة حسب مصدر التحديث
        if ($request->has('source') && $request->source !== 'all') {
            $query->where('update_source', $request->source);
        }
        
        // بحث
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('block_number', 'like', "%{$search}%")
                  ->orWhere('area', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        $blocks = $query->latest()->paginate(20);
        
        // المناطق المتاحة للفلترة
        $areas = EvacuationMap::select('area')->distinct()->pluck('area')->toArray();
        
        return view('admin.evacuation.index', compact('blocks', 'areas'));
    }

    // عرض نموذج إنشاء بلوك جديد
    public function create()
    {
        return view('admin.evacuation.create');
    }

    // تخزين بلوك جديد
    public function store(Request $request)
    {
        $validated = $request->validate([
            'block_number' => 'required|string|max:20|unique:evacuation_maps',
            'area' => 'required|string|max:100',
            'status' => 'required|in:safe,warning,danger,evacuation',
            'description' => 'nullable|string',
            'instructions' => 'nullable|string|max:500',
            'coordinates' => 'nullable|json',
            'population' => 'nullable|integer|min:0',
            'has_shelter' => 'boolean',
            'has_medical' => 'boolean',
            'has_water' => 'boolean',
            'update_source' => 'required|in:official,community,system'
        ]);

        $validated['last_updated'] = now();
        
        EvacuationMap::create($validated);

        return redirect()->route('admin.evacuation.index')
            ->with('success', 'تم إضافة البلوك بنجاح');
    }

    // عرض تفاصيل بلوك
    public function show(EvacuationMap $evacuation)
    {
        return view('admin.evacuation.show', compact('evacuation'));
    }

    // عرض نموذج تعديل بلوك
    public function edit(EvacuationMap $evacuation)
    {
        return view('admin.evacuation.edit', compact('evacuation'));
    }

    // تحديث البلوك
    public function update(Request $request, EvacuationMap $evacuation)
    {
        $validated = $request->validate([
            'block_number' => 'required|string|max:20|unique:evacuation_maps,block_number,' . $evacuation->id,
            'area' => 'required|string|max:100',
            'status' => 'required|in:safe,warning,danger,evacuation',
            'description' => 'nullable|string',
            'instructions' => 'nullable|string|max:500',
            'coordinates' => 'nullable|json',
            'population' => 'nullable|integer|min:0',
            'has_shelter' => 'boolean',
            'has_medical' => 'boolean',
            'has_water' => 'boolean',
            'update_source' => 'required|in:official,community,system'
        ]);

        $validated['last_updated'] = now();
        
        $evacuation->update($validated);

        return redirect()->route('admin.evacuation.index')
            ->with('success', 'تم تحديث البلوك بنجاح');
    }

    // حذف بلوك
    public function destroy(EvacuationMap $evacuation)
    {
        $evacuation->delete();

        return redirect()->route('admin.evacuation.index')
            ->with('success', 'تم حذف البلوك بنجاح');
    }

    // تحديث حالة بلوك معين
    public function updateStatus(Request $request, EvacuationMap $evacuation)
    {
        $request->validate([
            'status' => 'required|in:safe,warning,danger,evacuation'
        ]);
        
        $evacuation->update([
            'status' => $request->status,
            'last_updated' => now()
        ]);

        return back()->with('success', 'تم تحديث حالة البلوك بنجاح');
    }

    // تحديث عدة بلوكات دفعة واحدة
    public function bulkUpdate(Request $request)
    {
        $request->validate([
            'blocks' => 'required|array',
            'status' => 'required|in:safe,warning,danger,evacuation',
            'description' => 'nullable|string'
        ]);
        
        EvacuationMap::whereIn('id', $request->blocks)->update([
            'status' => $request->status,
            'description' => $request->description,
            'last_updated' => now(),
            'update_source' => 'official'
        ]);

        return back()->with('success', 'تم تحديث ' . count($request->blocks) . ' بلوك بنجاح');
    }

    // استيراد بيانات من ملف
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt'
        ]);
        
        // هنا يمكنك إضافة منطق استيراد البيانات من CSV
        // هذا مثال مبسط
        
        return back()->with('success', 'تم استيراد البيانات بنجاح');
    }

    // تصدير البيانات
    public function export()
    {
        $filename = 'evacuation_blocks_' . date('Y-m-d') . '.csv';
        
        // هنا يمكنك إضافة منطق تصدير البيانات إلى CSV
        
        return response()->streamDownload(function () {
            // محتوى CSV
        }, $filename);
    }
}