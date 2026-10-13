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
    public function options()
    {
        return $this->belongsToMany(Option::class, 'product_options', 'product_id', 'option_id');
    }

    public function saveOptions(array $rows): void
    {
        $existingIds = $this->options()->pluck('options.id')->all();
        $sync = [];

        foreach ($rows as $row) {
            $title = trim($row['title'] ?? '');
            if ($title === '') continue;

            $attrs = [
                'title' => $title,
                'description' => $row['description'] ?? null,
            ];

            $id = $row['id'] ?? null;
            if ($id && in_array($id, $existingIds, true)) {
                Option::whereKey($id)->update($attrs);
                $sync[$id] = [];
            } else {
                $option = Option::create($attrs);
                $sync[$option->id] = ['id' => (string) Str::uuid()];
            }
        }

        $removed = array_diff($existingIds, array_keys($sync));

        $this->options()->sync($sync);
        Option::whereIn('id', $removed)->delete();
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