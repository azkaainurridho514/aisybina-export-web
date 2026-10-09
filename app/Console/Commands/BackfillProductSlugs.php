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
        Product::whereNull("slug")
            ->chunkById(10, function($products){
                foreach($products as $product){
                    $slug = Str::slug($product->name);
                    $originalSlug = $slug;
                    $counter = 1;

                    while(
                        Product::where('slug', $slug)
                            ->where("id", '!=', $product->id)
                            ->exists()
                    ){
                        $slug = $originalSlug . "-" . $counter;
                        $counter++;
                    }

                    $product->update([
                        "slug" => $slug
                    ]);
                }
            });

        $this->info("Slug created");
        return self::SUCCESS;
    }
}
