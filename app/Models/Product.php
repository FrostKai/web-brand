<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Product extends Model
{
    protected $fillable = [
        'name', 'slug', 'category', 'category_label', 'price', 'old_price',
        'rating', 'reviews_count', 'badge', 'badge_type', 'emoji',
        'description', 'specs', 'colors', 'image_url', 'is_featured', 'stock',
    ];

    protected $casts = [
        'specs'       => 'array',
        'colors'      => 'array',
        'is_featured' => 'boolean',
        'price'       => 'float',
        'old_price'   => 'float',
        'rating'      => 'float',
    ];

    // Accessor: discount percentage
    protected function discountPercent(): Attribute
    {
        return Attribute::make(get: function () {
            if ($this->old_price && $this->old_price > $this->price) {
                return round((($this->old_price - $this->price) / $this->old_price) * 100);
            }
            return null;
        });
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Scopes
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeByCategory($query, string $category)
    {
        return $query->where('category', $category);
    }
}
