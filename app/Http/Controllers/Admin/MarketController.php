<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MarketItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MarketController extends Controller
{
    // عرض قائمة سلع السوق
    public function index(Request $request)
    {
        $query = MarketItem::query();
        
        // فلترة حسب الفئة
        if ($request->has('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }
        
        // فلترة حسب الحالة
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }
        
        // فلترة حسب التوفر
        if ($request->has('availability') && $request->availability !== 'all') {
            $query->where('availability', $request->availability);
        }
        
        // فلترة حسب الطوارئ
        if ($request->has('urgent') && $request->urgent !== 'all') {
            $query->where('is_urgent', $request->urgent === 'urgent');
        }
        
        // بحث
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }
        
        $items = $query->latest()->paginate(20);
        
        $stats = [
            'total'     => MarketItem::count(),
            'active'    => MarketItem::where('status', 'active')->count(),
            'pending'   => MarketItem::where('status', 'pending')->count(),
            'rejected'  => MarketItem::where('status', 'rejected')->count(),
        ];

    return view('admin.market.index', compact('items', 'stats'));
    }

    // عرض نموذج إنشاء سلعة جديدة
    public function create()
    {
        return view('admin.market.create');
    }

    // تخزين سلعة جديدة
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'category' => 'required|in:food,energy,medical,services',
            'availability' => 'required|in:available,scarce,out',
            'location' => 'required|string|max:500',
            'unit' => 'nullable|string|max:20',
            'quantity' => 'nullable|integer|min:1',
            'contact_info' => 'nullable|string|max:255',
            'image' => 'nullable|string',
            'status' => 'required|in:active,pending,rejected',
            'is_urgent' => 'boolean'
        ]);

        MarketItem::create($validated);

        return redirect()->route('admin.market.index')
            ->with('success', 'تم إضافة السلعة بنجاح');
    }

    // عرض تفاصيل سلعة
    public function show(MarketItem $market)
    {
        return view('admin.market.show', compact('market'));
    }

    // عرض نموذج تعديل سلعة
    public function edit(MarketItem $market)
    {
        return view('admin.market.edit', compact('market'));
    }

    // تحديث السلعة
    public function update(Request $request, MarketItem $market)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'category' => 'required|in:food,energy,medical,services',
            'availability' => 'required|in:available,scarce,out',
            'location' => 'required|string|max:500',
            'unit' => 'nullable|string|max:20',
            'quantity' => 'nullable|integer|min:1',
            'contact_info' => 'nullable|string|max:255',
            'image' => 'nullable|string',
            'status' => 'required|in:active,pending,rejected',
            'is_urgent' => 'boolean'
        ]);

        $market->update($validated);

        return redirect()->route('admin.market.index')
            ->with('success', 'تم تحديث السلعة بنجاح');
    }

    // حذف سلعة
    public function destroy(MarketItem $market)
    {
        $market->delete();

        return redirect()->route('admin.market.index')
            ->with('success', 'تم حذف السلعة بنجاح');
    }

    // تغيير حالة السلعة
    public function toggleStatus(Request $request, MarketItem $market)
    {
        $request->validate([
            'status' => 'required|in:active,pending,rejected'
        ]);
        
        $market->update(['status' => $request->status]);

        return back()->with('success', 'تم تغيير حالة السلعة بنجاح');
    }

    // تفعيل/تعطيل حالة الطوارئ
    public function toggleUrgent(MarketItem $market)
    {
        $market->update(['is_urgent' => !$market->is_urgent]);

        $status = $market->is_urgent ? 'مفعل' : 'معطل';
        return back()->with('success', "تم {$status} حالة الطوارئ بنجاح");
    }

    // تحديث عدة سلع دفعة واحدة
    public function bulkUpdate(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'action' => 'required|in:activate,deactivate,delete'
        ]);
        
        if ($request->action === 'delete') {
            MarketItem::whereIn('id', $request->items)->delete();
        } else {
            $status = $request->action === 'activate' ? 'active' : 'pending';
            MarketItem::whereIn('id', $request->items)->update(['status' => $status]);
        }

        return back()->with('success', 'تم تحديث السلع المحددة بنجاح');
    }

    // إحصائيات السوق
    public function statistics()
    {
        // إحصائيات الفئات
        $categoryStats = MarketItem::select('category', DB::raw('COUNT(*) as count'))
            ->where('status', 'active')
            ->groupBy('category')
            ->get();
        
        // إحصائيات التوفر
        $availabilityStats = MarketItem::select('availability', DB::raw('COUNT(*) as count'))
            ->where('status', 'active')
            ->groupBy('availability')
            ->get();
        
        // السلع الأكثر مشاهدة
        $mostViewed = MarketItem::where('status', 'active')
            ->orderBy('views', 'desc')
            ->limit(10)
            ->get();
        
        // السلع العاجلة
        $urgentItems = MarketItem::where('status', 'active')
            ->where('is_urgent', true)
            ->count();
        
        // الإحصائيات اليومية
        $dailyStats = [
            'today' => MarketItem::whereDate('created_at', today())->count(),
            'yesterday' => MarketItem::whereDate('created_at', today()->subDay())->count(),
            'week' => MarketItem::whereBetween('created_at', [today()->subWeek(), today()])->count(),
            'month' => MarketItem::whereBetween('created_at', [today()->subMonth(), today()])->count(),
        ];
        
        return view('admin.market.statistics', compact(
            'categoryStats', 
            'availabilityStats', 
            'mostViewed', 
            'urgentItems',
            'dailyStats'
        ));
 
    }

        // موافقة على السلعة
    public function approve(MarketItem $market)
    {
        $market->update([
            'status' => 'active',
            'rejection_reason' => null // مسح سبب الرفض إذا كان موجوداً
        ]);

        return back()->with('success', 'تمت الموافقة على السلعة بنجاح');
    }

    // رفض السلعة
    public function reject(Request $request, MarketItem $market)
    {
        $request->validate([
            'rejection_reason' => 'nullable|string|max:500'
        ]);

        $market->update([
            'status' => 'rejected',
            'rejection_reason' => $request->rejection_reason
        ]);

        return back()->with('success', 'تم رفض السلعة بنجاح');
    }

    // تعليق السلعة
    public function suspend(MarketItem $market)
    {
        $market->update([
            'status' => 'pending'
        ]);

        return back()->with('warning', 'تم تعليق السلعة بنجاح');
    }
}

