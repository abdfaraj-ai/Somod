<?php

namespace App\Http\Controllers;

use App\Models\Support;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SupportController extends Controller
{
    // عرض صفحة الدعم النفسي الرئيسية
    public function index(Request $request)
    {
        $category = $request->get('category', 'all');
        
        $query = Support::where('status', 'active')->where('verified', true);
        
        if ($category !== 'all') {
            $query->where('category', $category);
        }
        
        $supports = $query->latest()->get();
        
        // إحصاءات الفئات
        $categories = [
            'all' => [
                'name' => 'الكل', 
                'count' => Support::where('status', 'active')->where('verified', true)->count()
            ],
            'therapy' => [
                'name' => 'جلسات علاجية', 
                'count' => Support::where('status', 'active')->where('verified', true)->where('category', 'therapy')->count()
            ],
            'hotline' => [
                'name' => 'خطوط مساندة', 
                'count' => Support::where('status', 'active')->where('verified', true)->where('category', 'hotline')->count()
            ],
            'exercise' => [
                'name' => 'تمارين استرخاء', 
                'count' => Support::where('status', 'active')->where('verified', true)->where('category', 'exercise')->count()
            ],
            'advice' => [
                'name' => 'نصائح وإرشادات', 
                'count' => Support::where('status', 'active')->where('verified', true)->where('category', 'advice')->count()
            ],
            'group' => [
                'name' => 'مجموعات دعم', 
                'count' => Support::where('status', 'active')->where('verified', true)->where('category', 'group')->count()
            ],
        ];
        
        // خطوط المساندة الساخنة
        $hotlines = Support::where('status', 'active')
            ->where('verified', true)
            ->where('category', 'hotline')
            ->inRandomOrder()
            ->limit(5)
            ->get();
        
        return view('support.index', compact('supports', 'categories', 'category', 'hotlines'));
    }
    
    // عرض تفاصيل خدمة دعم
    public function show($id)
    {
        $support = Support::where('status', 'active')
            ->where('verified', true)
            ->findOrFail($id);
        
        // زيادة عدد المشاهدات
        $support->incrementViews();
        
        // خدمات دعم مشابهة
        $relatedSupports = Support::where('status', 'active')
            ->where('verified', true)
            ->where('category', $support->category)
            ->where('id', '!=', $support->id)
            ->inRandomOrder()
            ->limit(3)
            ->get();
        
        return view('support.show', compact('support', 'relatedSupports'));
    }

    // عرض تمارين الاسترخاء
    public function exercises()
    {
        $exercises = Support::where('status', 'active')
            ->where('verified', true)
            ->where('category', 'exercise')
            ->get();
            
        return view('support.exercises', compact('exercises'));
    }

    // البحث في خدمات الدعم
    public function search(Request $request)
    {
        $request->validate([
            'query' => 'required|string|min:2'
        ]);
        
        $query = $request->query;
        
        $supports = Support::where('status', 'active')
            ->where('verified', true)
            ->where(function($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('description', 'like', "%{$query}%");
            })
            ->get();
        
        return view('support.search', compact('supports', 'query'));
    }
}