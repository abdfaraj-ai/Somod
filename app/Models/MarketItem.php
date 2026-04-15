<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MarketItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'price',
        'category',
        'availability',
        'location',
        'unit',
        'quantity',
        'contact_info',
        'image',
        'status',
        'is_urgent',
        'views'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_urgent' => 'boolean',
        'views' => 'integer'
    ];

    // نطاقات البحث (Scopes)
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeFood($query)
    {
        return $query->where('category', 'food');
    }

    public function scopeEnergy($query)
    {
        return $query->where('category', 'energy');
    }

    public function scopeMedical($query)
    {
        return $query->where('category', 'medical');
    }

    public function scopeServices($query)
    {
        return $query->where('category', 'services');
    }

    public function scopeUrgent($query)
    {
        return $query->where('is_urgent', true);
    }

    public function scopeAvailable($query)
    {
        return $query->where('availability', 'available');
    }

    // طريقة للحصول على الفئة بالعربية
    public function getCategoryArabicAttribute()
    {
        $categories = [
            'food' => 'مواد غذائية',
            'energy' => 'طاقة ووقود',
            'medical' => 'صحة وأدوية',
            'services' => 'خدمات'
        ];
        
        return $categories[$this->category] ?? $this->category;
    }

    // طريقة للحصول على حالة التوفر بالعربية
    public function getAvailabilityArabicAttribute()
    {
        $availability = [
            'available' => 'متوفر بكثرة',
            'scarce' => 'شحيح / قليل',
            'out' => 'غير متوفر'
        ];
        
        return $availability[$this->availability] ?? $this->availability;
    }

    // طريقة للحصول على لون حالة التوفر
    public function getAvailabilityColorAttribute()
    {
        $colors = [
            'available' => 'success',
            'scarce' => 'warning',
            'out' => 'danger'
        ];
        
        return $colors[$this->availability] ?? 'secondary';
    }

    // طريقة للحصول على أيقونة الفئة
    public function getCategoryIconAttribute()
    {
        $icons = [
            'food' => 'bi-basket',
            'energy' => 'bi-lightning',
            'medical' => 'bi-capsule',
            'services' => 'bi-gear'
        ];
        
        return $icons[$this->category] ?? 'bi-box';
    }

    // طريقة للحصول على حالة العنصر بالعربية
    public function getStatusArabicAttribute()
    {
        $statuses = [
            'active' => 'نشط',
            'pending' => 'قيد المراجعة',
            'rejected' => 'مرفوض'
        ];
        
        return $statuses[$this->status] ?? $this->status;
    }

    // طريقة للحصول على لون الحالة
    public function getStatusColorAttribute()
    {
        $colors = [
            'active' => 'success',
            'pending' => 'warning',
            'rejected' => 'danger'
        ];
        
        return $colors[$this->status] ?? 'secondary';
    }

    // زيادة عدد المشاهدات
    public function incrementViews()
    {
        $this->increment('views');
    }

    // عرض السعر مع الوحدة
    public function getFormattedPriceAttribute()
    {
        if (!$this->price) {
            return 'غير محدد';
        }
        
        $price = number_format($this->price, 2);
        $unit = $this->unit ? "/{$this->unit}" : '';
        
        return "{$price} شيكل{$unit}";
    }
}