<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\InquiryForm;
use App\Models\OurProcess;
use App\Models\Product;
use App\Support\SiteCache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    /** Statistik disimpan 10 menit; juga dihapus saat kategori/produk/proses berubah. */
    private const STATS_TTL = 600;

    /**
     * Halaman dashboard (Blade). Permintaan JSON (SPA admin lama)
     * tetap dilayani dengan format yang sama seperti sebelumnya.
     */
    public function index(Request $request)
    {
        $stats = Cache::remember(SiteCache::STATS, self::STATS_TTL, function () {
            return [
                'products'   => Product::count(),
                'categories' => Category::count(),
                'inquiries'  => InquiryForm::count(),
                'process'    => OurProcess::count(),
            ];
        });

        if ($request->expectsJson()) {
            return response()->json($stats);
        }

        return view('admin.dashboard.index', ['stats' => $stats]);
    }
}
