<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Story extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'excerpt',
        'author_name',
        'author_location',
        'category',
        'image_path',
        'is_featured',
        'is_published',
        'views_count',
        'likes_count',
        'published_at'
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_published' => 'boolean',
        'published_at' => 'datetime'
    ];

    // Auto-generate slug from title
    public static function boot()
    {
        parent::boot();

        static::creating(function ($story) {
            $story->slug = Str::slug($story->title);
        });

        static::updating(function ($story) {
            if ($story->isDirty('title')) {
                $story->slug = Str::slug($story->title);
            }
        });
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    // Methods
    public function getCategoryArabicAttribute()
    {
        $categories = [
            'resilience' => 'إرادة صلبة',
            'solidarity' => 'تكافل اجتماعي',
            'innovation' => 'إبداع وتحدي',
            'heroes' => 'أبطال الميدان',
            'hope' => 'أمل وتفاؤل'
        ];
        
        return $categories[$this->category] ?? $this->category;
    }

    public function getReadingTimeAttribute()
    {
        $wordCount = str_word_count(strip_tags($this->content));
        $minutes = ceil($wordCount / 200);
        return $minutes;
    }

    public function incrementViews()
    {
        $this->views_count++;
        $this->save();
    }
}