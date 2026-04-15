<?php

namespace App\Http\Controllers;

use App\Models\Story;
use Illuminate\Http\Request;

class StoryController extends Controller
{
    // عرض جميع القصص
    public function index(Request $request)
    {
        $category = $request->get('category', 'all');
        
        $query = Story::published()->latest('published_at');
        
        if ($category !== 'all') {
            $query->where('category', $category);
        }
        
        $stories = $query->paginate(9);
        
        // القصص المميزة
        $featuredStories = Story::published()->featured()->latest('published_at')->take(3)->get();
        
        // الإحصائيات
        $stats = [
            'total' => Story::published()->count(),
            'resilience' => Story::published()->where('category', 'resilience')->count(),
            'solidarity' => Story::published()->where('category', 'solidarity')->count(),
            'innovation' => Story::published()->where('category', 'innovation')->count(),
        ];
        
        return view('stories.index', compact('stories', 'featuredStories', 'stats', 'category'));
    }

    // عرض قصة واحدة
    public function show($slug)
    {
        $story = Story::published()->where('slug', $slug)->firstOrFail();
        
        // زيادة عدد المشاهدات
        $story->incrementViews();
        
        // قصص مشابهة
        $relatedStories = Story::published()
            ->where('category', $story->category)
            ->where('id', '!=', $story->id)
            ->latest('published_at')
            ->take(3)
            ->get();
        
        return view('stories.show', compact('story', 'relatedStories'));
    }

    // إرسال قصة جديدة من المستخدمين
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string|min:100',
            'author_name' => 'nullable|string|max:100',
            'author_location' => 'required|string|max:100',
            'category' => 'required|in:resilience,solidarity,innovation,heroes,hope',
            'email' => 'nullable|email'
        ]);

        // هنا يمكن إضافة منطق لإرسال الإيميل أو حفظ القصة كمسودة
        
        return back()->with('success', 'شكراً لمشاركة قصتك. سيتم مراجعتها ونشرها قريباً.');
    }

    // البحث في القصص
    public function search(Request $request)
    {
        $query = $request->get('q');
        
        $stories = Story::published()
            ->where(function ($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('content', 'like', "%{$query}%")
                  ->orWhere('author_name', 'like', "%{$query}%")
                  ->orWhere('author_location', 'like', "%{$query}%");
            })
            ->paginate(12);
        
        return view('stories.search', compact('stories', 'query'));
    }
}