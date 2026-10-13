<?php

namespace App\Console\Commands;

use App\Models\Category;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class BackfillCategorySlugs extends Command
{
    protected $signature = 'app:backfill-category-slugs';
    protected $description = 'Command description';
    public function handle()
    {
        $total = Category::whereNull('slug')->count();

        $this->info("Category dengan slug NULL: {$total}");

        Category::whereNull('slug')
            ->chunkById(10, function ($categorys) {
                foreach ($categorys as $category) {
                    $slug = Str::slug($category->name);
                    
                    $this->line(
                        "ID: {$category->id} | Name: {$category->name} | Slug: {$slug}"
                    );

                    $category->slug = $slug;
                    $category->save();

                    $this->line("Slug tersimpan: {$category->slug}");
                }
            });

        return self::SUCCESS;
    }
}
