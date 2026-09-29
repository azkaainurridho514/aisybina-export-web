<?php

namespace App\Observers;

use App\Models\Category;
use App\Support\SiteCache;

class CategoryObserver
{
    public function saved(Category $category): void
    {
        SiteCache::forget('categories');
    }

    public function deleted(Category $category): void
    {
        SiteCache::forget('categories');
    }
}
