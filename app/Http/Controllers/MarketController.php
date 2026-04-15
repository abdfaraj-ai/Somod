<?php

namespace App\Http\Controllers;

use App\Models\MarketItem;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MarketController extends Controller
{
    // عرض صفحة السوق الرئيسية
    public function index(Request $request)
    {
        $category = $request->get('category', 'all');
        
        $query = MarketItem::where('status', 'active');
        
        if ($category !== 'all') {
            $query->where('category', $category);
        }
        
        // فلترة إضافية حسب التوفر
        $availability = $request->get('availability', 'all');
        if ($availability !== 'all') {
            $query->where('availability', $availability);
        }
        
        // فلترة حسب حالة الطوارئ
        if ($request->has('urgent')) {
            $query->where('is_urgent', true);
        }
        
        // ترتيب حسب
        $sort = $request->get('sort', 'newest');
        switch ($sort) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'views':
                $query->orderBy('views', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }
        
        $items = $query->paginate(12);
        
        // إحصاءات
        $stats = [
            'total' => MarketItem::where('status', 'active')->count(),
            'food' => MarketItem::where('status', 'active')->where('category', 'food')->count(),
            'energy' => MarketItem::where('status', 'active')->where('category', 'energy')->count(),
            'medical' => MarketItem::where('status', 'active')->where('category', 'medical')->count(),
            'services' => MarketItem::where('status', 'active')->where('category', 'services')->count(),
        ];
        
        return view('market.index', compact('items', 'stats', 'category', 'availability', 'sort'));
    }

    // عرض تفاصيل سلعة
    public function show($id)
    {
        $item = MarketItem::where('status', 'active')->findOrFail($id);
        
        // زيادة عدد المشاهدات
        $item->incrementViews();
        
        // سلع مشابهة
        $relatedItems = MarketItem::where('status', 'active')
            ->where('category', $item->category)
            ->where('id', '!=', $item->id)
            ->inRandomOrder()
            ->limit(4)
            ->get();
        
        return view('market.show', compact('item', 'relatedItems'));
    }

    // البحث في السوق
    public function search(Request $request)
    {
        $query = $request->get('q');
        
        $items = MarketItem::where('status', 'active')
            ->where(function($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                  ->orWhere('description', 'like', "%{$query}%")
                  ->orWhere('location', 'like', "%{$query}%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(12);
        
        return view('market.search', compact('items', 'query'));
    }

    // الحصول على بيانات السوق كـ JSON (للاستخدام في JavaScript)
    public function getMarketData()
    {
        $items = MarketItem::where('status', 'active')
            ->select('id', 'name', 'category', 'price', 'availability', 'location', 'description')
            ->get();
        
        return response()->json($items);
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'price' => 'nullable|numeric',
        'category' => 'required|in:food,energy,medical,services',
        'availability' => 'required|in:available,scarce,out',
        'location' => 'required|string|max:255',
        'status' => 'required|in:active,pending,rejected'
    ]);

    MarketItem::create($validated);

    return redirect()->route('market.index')
        ->with('success', 'تم إرسال السلعة وسيتم مراجعتها.');
}

}