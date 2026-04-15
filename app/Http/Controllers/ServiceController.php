<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $category = $request->get('category', 'all');
        
        $query = Service::where('status', 'active')->where('verified', true);
        
        if ($category !== 'all') {
            $query->where('category', $category);
        }
        
        $services = $query->latest()->get();
        
        $categories = [
            'all' => [
                'name' => 'الكل', 
                'count' => Service::where('status', 'active')->where('verified', true)->count()
            ],
            'medical' => [
                'name' => 'طبي', 
                'count' => Service::where('status', 'active')->where('verified', true)->where('category', 'medical')->count()
            ],
            'shelter' => [
                'name' => 'إيواء', 
                'count' => Service::where('status', 'active')->where('verified', true)->where('category', 'shelter')->count()
            ],
            'edu' => [
                'name' => 'تعليم', 
                'count' => Service::where('status', 'active')->where('verified', true)->where('category', 'edu')->count()
            ],
            'org' => [
                'name' => 'مؤسسات', 
                'count' => Service::where('status', 'active')->where('verified', true)->where('category', 'org')->count()
            ],
            'water' => [
                'name' => 'مياه', 
                'count' => Service::where('status', 'active')->where('verified', true)->where('category', 'water')->count()
            ],
        ];
        
        return view('services.index', compact('services', 'categories', 'category'));
    }
    
    public function show($id)
    {
        $service = Service::where('status', 'active')
            ->where('verified', true)
            ->findOrFail($id);
        
        $relatedServices = Service::where('status', 'active')
            ->where('verified', true)
            ->where('category', $service->category)
            ->where('id', '!=', $service->id)
            ->inRandomOrder()
            ->limit(3)
            ->get();
        
        if ($relatedServices->isEmpty()) {
            $relatedServices = collect();
        }
        
        return view('services.show', compact('service', 'relatedServices'));
    }
}