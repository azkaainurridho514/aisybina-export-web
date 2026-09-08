<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\OurProcess;
use App\Models\ChooseUs;
use App\Models\AboutItem;
use App\Models\BusinessHour;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function getData()
    {
        return response()->json([
            'master' => DB::table('master')->first(),
            'ask_us' => DB::table('ask_us')->first(),
            'global_reach' => DB::table('global_reach')->first(),
            'footer' => DB::table('footer')->first(),

            'categories' => Category::latest()->get(),

            'products' => Product::with('category')
                ->latest()
                ->get(),

            'our_process' => OurProcess::latest()->get(),
            'choose_us' => ChooseUs::latest()->get(),
            'about_item' => AboutItem::latest()->get(),
            'business_hours' => BusinessHour::latest()->get(),
        ]);
    }
}