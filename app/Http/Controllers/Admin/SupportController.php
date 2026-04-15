<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Support;
use Illuminate\Http\Request;

class SupportController extends Controller
{
    // عرض قائمة خدمات الدعم
    public function index(Request $request)
    {
        $query = Support::query();
        
        // فلترة حسب الفئة
        if ($request->has('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }
        
        // فلترة حسب الحالة
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }
        
        // فلترة حسب التحقق
        if ($request->has('verified') && $request->verified !== 'all') {
            $query->where('verified', $request->verified === 'verified');
        }
        
        // فلترة حسب المجانية
        if ($request->has('free') && $request->free !== 'all') {
            $query->where('is_free', $request->free === 'free');
        }
        
        // بحث
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }
        
        $supports = $query->latest()->paginate(20);
        
        return view('admin.support.index', compact('supports'));
    }

    // عرض نموذج إنشاء خدمة دعم
    public function create()
    {
        return view('admin.support.create');
    }

    // تخزين خدمة دعم جديدة
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|in:therapy,hotline,exercise,advice,group',
            'phone' => 'nullable|string|max:20',
            'whatsapp' => 'nullable|string|max:20',
            'email' => 'nullable|email',
            'website' => 'nullable|url',
            'working_hours' => 'nullable|string|max:255',
            'is_free' => 'boolean',
            'language' => 'required|in:ar,en,both',
            'specialties' => 'nullable|array',
            'specialties.*' => 'string|max:100',
            'status' => 'required|in:active,inactive',
            'verified' => 'boolean'
        ]);

        // تحويل التخصصات إلى JSON
        if ($request->has('specialties')) {
            $validated['specialties'] = json_encode($request->specialties);
        }

        Support::create($validated);

        return redirect()->route('admin.support.index')
            ->with('success', 'تم إضافة خدمة الدعم بنجاح');
    }

    // عرض تفاصيل خدمة دعم
    public function show(Support $support)
    {
        return view('admin.support.show', compact('support'));
    }

    // عرض نموذج تعديل خدمة دعم
    public function edit(Support $support)
    {
        return view('admin.support.edit', compact('support'));
    }

    // تحديث خدمة الدعم
    public function update(Request $request, Support $support)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|in:therapy,hotline,exercise,advice,group',
            'phone' => 'nullable|string|max:20',
            'whatsapp' => 'nullable|string|max:20',
            'email' => 'nullable|email',
            'website' => 'nullable|url',
            'working_hours' => 'nullable|string|max:255',
            'is_free' => 'boolean',
            'language' => 'required|in:ar,en,both',
            'specialties' => 'nullable|array',
            'specialties.*' => 'string|max:100',
            'status' => 'required|in:active,inactive',
            'verified' => 'boolean'
        ]);

        // تحويل التخصصات إلى JSON
        if ($request->has('specialties')) {
            $validated['specialties'] = json_encode($request->specialties);
        } elseif ($request->has('specialties_clear')) {
            $validated['specialties'] = null;
        }

        $support->update($validated);

        return redirect()->route('admin.support.index')
            ->with('success', 'تم تحديث خدمة الدعم بنجاح');
    }

    // حذف خدمة الدعم
    public function destroy(Support $support)
    {
        $support->delete();

        return redirect()->route('admin.support.index')
            ->with('success', 'تم حذف خدمة الدعم بنجاح');
    }

    // تفعيل/تعطيل خدمة الدعم
    public function toggleStatus(Support $support)
    {
        $support->update([
            'status' => $support->status === 'active' ? 'inactive' : 'active'
        ]);

        $status = $support->status === 'active' ? 'مفعلة' : 'معطلة';
        return back()->with('success', "تم {$status} خدمة الدعم بنجاح");
    }

    // التحقق من خدمة الدعم
    public function toggleVerification(Support $support)
    {
        $support->update([
            'verified' => !$support->verified
        ]);

        $status = $support->verified ? 'متحقق منها' : 'غير متحقق منها';
        return back()->with('success', "تم تغيير حالة التحقق للخدمة إلى {$status}");
    }

    // إعادة تعيين عدد المشاهدات
    public function resetViews(Support $support)
    {
        $support->update(['views' => 0]);
        
        return back()->with('success', 'تم إعادة تعيين عدد المشاهدات');
    }
}