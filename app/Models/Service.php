<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'category',
        'address',
        'phone',
        'whatsapp',
        'email',
        'website',
        'working_hours',
        'status',
        'verified'
    ];

    protected $casts = [
        'verified' => 'boolean'
    ];

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeVerified($query)
    {
        return $query->where('verified', true);
    }

    public function scopeMedical($query)
    {
        return $query->where('category', 'medical');
    }

    public function scopeShelter($query)
    {
        return $query->where('category', 'shelter');
    }

    public function scopeEducation($query)
    {
        return $query->where('category', 'edu');
    }

    public function scopeOrganization($query)
    {
        return $query->where('category', 'org');
    }

    public function scopeWater($query)
    {
        return $query->where('category', 'water');
    }

    public function getCategoryArabicAttribute()
    {
        $categories = [
            'medical' => 'طبي',
            'shelter' => 'إيواء',
            'edu' => 'تعليم',
            'org' => 'مؤسسات',
            'water' => 'مياه'
        ];
        
        return $categories[$this->category] ?? $this->category;
    }

    public function getCategoryIconAttribute()
    {
        $icons = [
            'medical' => 'bi-hospital',
            'shelter' => 'bi-house-heart',
            'edu' => 'bi-book',
            'org' => 'bi-building',
            'water' => 'bi-droplet'
        ];
        
        return $icons[$this->category] ?? 'bi-info-circle';
    }

public function getCategoryColorAttribute()
{
    $colors = [
        'medical' => 'danger',
        'shelter' => 'warning',
        'edu' => 'primary',
        'org' => 'success',
        'water' => 'info'
    ];
    
    return $colors[$this->category] ?? 'secondary';
}



}