<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasUuids;

    protected $table = 'products';

    protected $fillable = [
        'category_id',
        'name',
        'description',
    ];
    
    public function productOptions()
    {
        return $this->hasMany(ProductOption::class, 'product_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_id');
    }

    protected static function booted() {
        static::creating(function (Product $product) {
            if (empty($product->slug)) {
                $product->slug = static::generateUniqueSlug($product->name);
            }
        });
    }
    

    
    protected static function generateUniqueSlug(
        string $name,
        ?string $ignoreId = null
    ): string {
        $slug = Str::slug($name);

        $originalSlug = $slug;
        $counter = 1;

        while (
            static::where('slug', $slug)
                ->when(
                    $ignoreId,
                    fn ($query) => $query->where('id', '!=', $ignoreId)
                )
                ->exists()
        ) {
            $slug = "{$originalSlug}-{$counter}";
            $counter++;
        }

        return $slug;
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}