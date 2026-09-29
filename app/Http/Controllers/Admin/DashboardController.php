<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\InquiryForm;
use App\Models\OurProcess;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard.index', [
            'stats' => [
                'products'   => Product::count(),
                'categories' => Category::count(),
                'inquiries'  => InquiryForm::count(),
                'process'    => OurProcess::count(),
            ],
        ]);
    }
}
