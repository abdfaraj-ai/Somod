<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Support extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'category',
        'phone',
        'whatsapp',
        'email',
        'website',
        'working_hours',
        'is_free',
        'language',
        'specialties',
        'status',
        'verified',
        'views'
    ];

    protected $casts = [
        'specialties' => 'array',
        'is_free' => 'boolean',
        'verified' => 'boolean',
        'views' => 'integer'
    ];

    // نطاقات البحث (Scopes)
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeVerified($query)
    {
        return $query->where('verified', true);
    }

    public function scopeFree($query)
    {
        return $query->where('is_free', true);
    }

    public function scopeTherapy($query)
    {
        return $query->where('category', 'therapy');
    }

    public function scopeHotline($query)
    {
        return $query->where('category', 'hotline');
    }

    public function scopeExercise($query)
    {
        return $query->where('category', 'exercise');
    }

    public function scopeAdvice($query)
    {
        return $query->where('category', 'advice');
    }

    public function scopeGroup($query)
    {
        return $query->where('category', 'group');
    }

    public function scopeArabic($query)
    {
        return $query->where('language', 'ar')->orWhere('language', 'both');
    }

    // طريقة للحصول على الفئة بالعربية
    public function getCategoryArabicAttribute()
    {
        $categories = [
            'therapy' => 'جلسات علاجية',
            'hotline' => 'خطوط مساندة',
            'exercise' => 'تمارين استرخاء',
            'advice' => 'نصائح وإرشادات',
            'group' => 'مجموعات دعم'
        ];
        
        return $categories[$this->category] ?? $this->category;
    }

    // طريقة للحصول على أيقونة الفئة
    public function getCategoryIconAttribute()
    {
        $icons = [
            'therapy' => 'bi-chat-heart',
            'hotline' => 'bi-telephone',
            'exercise' => 'bi-wind',
            'advice' => 'bi-lightbulb',
            'group' => 'bi-people'
        ];
        
        return $icons[$this->category] ?? 'bi-info-circle';
    }

    // طريقة للحصول على لون الفئة
    public function getCategoryColorAttribute()
    {
        $colors = [
            'therapy' => 'success',
            'hotline' => 'danger',
            'exercise' => 'primary',
            'advice' => 'warning',
            'group' => 'info'
        ];
        
        return $colors[$this->category] ?? 'secondary';
    }

    // طريقة للحصول على اللغة بالعربية
    public function getLanguageArabicAttribute()
    {
        $languages = [
            'ar' => 'عربي',
            'en' => 'إنجليزي',
            'both' => 'العربية والإنجليزية'
        ];
        
        return $languages[$this->language] ?? $this->language;
    }

    // زيادة عدد المشاهدات
    public function incrementViews()
    {
        $this->increment('views');
    }

    public function getSpecialtiesArrayAttribute()
    {
        $value = $this->specialties;

        if (!$value) {
            return [];
        }

        if (is_array($value)) {
            return $value;
        }

        $decoded = json_decode($value, true);

        return is_array($decoded) ? $decoded : [];
    }


}