<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;

class ProductPageController extends Controller
{
    public function getData()
    {
        return response()->json([
            'categories' => Category::latest()->get(),

            'products' => Product::with([
                'category',
                'images'
            ])->latest()->get(),
        ]);
    }
}