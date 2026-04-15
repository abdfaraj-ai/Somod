<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EvacuationMap extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'block_number',
        'area',
        'status',
        'description',
        'instructions',
        'coordinates',
        'population',
        'has_shelter',
        'has_medical',
        'has_water',
        'last_updated',
        'update_source'
    ];

    protected $casts = [
        'coordinates' => 'array',
        'has_shelter' => 'boolean',
        'has_medical' => 'boolean',
        'has_water' => 'boolean',
        'last_updated' => 'datetime'
    ];

    public function scopeSafe($query)
    {
        return $query->where('status', 'safe');
    }

    public function scopeWarning($query)
    {
        return $query->where('status', 'warning');
    }

    public function scopeDanger($query)
    {
        return $query->where('status', 'danger');
    }

    public function scopeEvacuation($query)
    {
        return $query->where('status', 'evacuation');
    }

    public function scopeByArea($query, $area)
    {
        return $query->where('area', $area);
    }

    public function getStatusArabicAttribute()
    {
        $statuses = [
            'safe' => 'آمن',
            'warning' => 'تحذير',
            'danger' => 'خطر',
            'evacuation' => 'إخلاء فوري'
        ];
        
        return $statuses[$this->status] ?? $this->status;
    }

    public function getStatusColorAttribute()
    {
        $colors = [
            'safe' => 'success',
            'warning' => 'warning',
            'danger' => 'danger',
            'evacuation' => 'dark'
        ];
        
        return $colors[$this->status] ?? 'secondary';
    }

    public function getStatusIconAttribute()
    {
        $icons = [
            'safe' => 'bi-shield-check',
            'warning' => 'bi-exclamation-triangle',
            'danger' => 'bi-exclamation-circle',
            'evacuation' => 'bi-people-fill'
        ];
        
        return $icons[$this->status] ?? 'bi-info-circle';
    }

    public function getUpdateSourceArabicAttribute()
    {
        $sources = [
            'official' => 'رسمي',
            'community' => 'مجتمعي',
            'system' => 'نظام'
        ];
        
        return $sources[$this->update_source] ?? $this->update_source;
    }

    public function getNeedsEvacuationAttribute()
    {
        return in_array($this->status, ['danger', 'evacuation']);
    }
}