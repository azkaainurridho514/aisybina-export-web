<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class BackfillProductSlugs extends Command
{
    protected $signature = 'app:backfill-product-slugs';
    protected $description = 'Command description';
    public function handle()
    {
        $total = Product::whereNull('slug')->count();

        $this->info("Produk dengan slug NULL: {$total}");

        Product::whereNull('slug')
            ->chunkById(10, function ($products) {
                foreach ($products as $product) {
                    $slug = Str::slug($product->name);
                    
                    $this->line(
                        "ID: {$product->id} | Name: {$product->name} | Slug: {$slug}"
                    );

                    $product->slug = $slug;
                    $product->save();

                    $this->line("Slug tersimpan: {$product->slug}");
                }
            });

        return self::SUCCESS;
    }
}
