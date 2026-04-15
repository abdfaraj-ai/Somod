<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Story;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StoryController extends Controller
{
    // عرض جميع القصص
    public function index(Request $request)
    {
        $query = Story::query();
        
        // فلترة حسب الحالة
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('is_published', $request->status === 'published');
        }
        
        // فلترة حسب الفئة
        if ($request->has('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }
        
        // البحث
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%")
                  ->orWhere('author_name', 'like', "%{$search}%");
            });
        }
        
        $stories = $query->latest()->paginate(20);
        
        return view('admin.stories.index', compact('stories'));
    }

    // عرض نموذج إنشاء قصة
    public function create()
    {
        return view('admin.stories.create');
    }

    // حفظ قصة جديدة
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string|min:100',
            'excerpt' => 'nullable|string|max:500',
            'author_name' => 'nullable|string|max:100',
            'author_location' => 'required|string|max:100',
            'category' => 'required|in:resilience,solidarity,innovation,heroes,hope',
            'image' => 'nullable|image|max:2048',
            'is_featured' => 'boolean',
            'is_published' => 'boolean'
        ]);

        // معالجة الصورة
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('stories', 'public');
            $validated['image_path'] = $path;
        }

        // إذا كانت القصة منشورة، ضع تاريخ النشر
        if ($request->has('is_published') && $request->is_published) {
            $validated['published_at'] = now();
        }

        Story::create($validated);

        return redirect()->route('admin.stories.index')
            ->with('success', 'تم إضافة القصة بنجاح');
    }

    // عرض قصة واحدة
    public function show(Story $story)
    {
        return view('admin.stories.show', compact('story'));
    }

    // عرض نموذج تعديل قصة
    public function edit(Story $story)
    {
        return view('admin.stories.edit', compact('story'));
    }

    // تحديث القصة
    public function update(Request $request, Story $story)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string|min:100',
            'excerpt' => 'nullable|string|max:500',
            'author_name' => 'nullable|string|max:100',
            'author_location' => 'required|string|max:100',
            'category' => 'required|in:resilience,solidarity,innovation,heroes,hope',
            'image' => 'nullable|image|max:2048',
            'is_featured' => 'boolean',
            'is_published' => 'boolean'
        ]);

        // معالجة الصورة
        if ($request->hasFile('image')) {
            // حذف الصورة القديمة إن وجدت
            if ($story->image_path) {
                Storage::disk('public')->delete($story->image_path);
            }
            
            $path = $request->file('image')->store('stories', 'public');
            $validated['image_path'] = $path;
        }

        // إذا كانت القصة تنشر لأول مرة
        if ($request->has('is_published') && $request->is_published && !$story->is_published) {
            $validated['published_at'] = now();
        }

        $story->update($validated);

        return redirect()->route('admin.stories.index')
            ->with('success', 'تم تحديث القصة بنجاح');
    }

    // حذف القصة
    public function destroy(Story $story)
    {
        // حذف الصورة إن وجدت
        if ($story->image_path) {
            Storage::disk('public')->delete($story->image_path);
        }

        $story->delete();

        return redirect()->route('admin.stories.index')
            ->with('success', 'تم حذف القصة بنجاح');
    }

    // تغيير حالة النشر
    public function togglePublish(Story $story)
    {
        $story->update([
            'is_published' => !$story->is_published,
            'published_at' => $story->is_published ? null : now()
        ]);

        $status = $story->is_published ? 'منشورة' : 'مسودة';
        return back()->with('success', "تم تغيير حالة القصة إلى {$status}");
    }

    // تغيير حالة التميز
    public function toggleFeatured(Story $story)
    {
        $story->update([
            'is_featured' => !$story->is_featured
        ]);

        $status = $story->is_featured ? 'مميزة' : 'عادية';
        return back()->with('success', "تم تغيير حالة القصة إلى {$status}");
    }
}