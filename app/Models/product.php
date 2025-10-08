<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'brand',
        'price',
        'stock',
        'description',
        'category_id',
        'status',
        'images', // JSON column (if still present)
    ];

    // If you keep a JSON `images` column, cast it to array
    protected $casts = [
        'images' => 'array',
    ];

    // Relationship to Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relationship to product_images table
    public function productImages()
    {
        return $this->hasMany(ProductImage::class);
    }

    /**
     * Convenience accessor: first image path (prefers productImages relation,
     * falls back to JSON `images` column).
     *
     * Usage in blade: $product->first_image
     * or helper method: $product->firstImageUrl() below
     */
    public function getFirstImageAttribute()
    {
        // If relation data exists, use first productImages record
        if ($this->relationLoaded('productImages') || $this->productImages()->exists()) {
            $first = $this->productImages->first();
            if ($first && $first->image) {
                return $first->image;
            }
        }

        // Fallback to JSON column `images`
        $imgs = $this->images;
        if (is_array($imgs) && count($imgs) > 0) {
            return $imgs[0];
        }

        return null;
    }

    // helper: get full storage url
    public function firstImageUrl($fallback = null)
    {
        $img = $this->first_image;
        if ($img) {
            return asset('storage/' . $img);
        }
        return $fallback ?: 'https://via.placeholder.com/500x500?text=No+Image';
    }
}
