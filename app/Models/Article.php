<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'slug',
        'article_type',      // internal or external
        'external_url',      // URL untuk artikel eksternal
        'source_name',       // Nama sumber (Kompas, Detik, dll)
        'excerpt',
        'content',
        'featured_image',
        'status',
        'published_at',
        'tags',
        'views',
        'view_count',
        'like_count',
    ];

    protected $casts = [
        'tags' => 'array',
        'view_count' => 'integer',
        'like_count' => 'integer',
        'views' => 'integer',
        'published_at' => 'datetime',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Alias untuk user (agar bisa pakai $article->author)
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('status', 'published')
                    ->whereNotNull('published_at')
                    ->where('published_at', '<=', now());
    }

    public function scopePopular($query)
    {
        return $query->orderBy('view_count', 'desc');
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('published_at', 'desc');
    }

    // Accessor untuk cek apakah artikel eksternal
    public function getIsExternalAttribute()
    {
        return $this->article_type === 'external';
    }

    // Accessor untuk URL artikel (internal atau eksternal)
    public function getUrlAttribute()
    {
        if ($this->is_external && $this->external_url) {
            return $this->external_url;
        }
        return route('articles.show', $this->slug);
    }
}
