<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductPageController;
use App\Http\Controllers\ContactController;

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SiteContentController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\InquiryFormController;
use App\Http\Controllers\Admin\BusinessHourController;
use App\Http\Controllers\Admin\OurProcessController;
use App\Http\Controllers\Admin\OurMissionController;
use App\Http\Controllers\Admin\OurValueController;
use App\Http\Controllers\Admin\ChooseUsController;
use App\Http\Controllers\Admin\AboutItemController;
use App\Http\Controllers\GuestController;


Route::get('/', [GuestController::class, 'index'])->name('home');
Route::get('/about', [GuestController::class, 'about'])->name('about');
 
Route::get('/products', [GuestController::class, 'products'])->name('products');
Route::get('/products/data', [GuestController::class, 'productsData'])->name('products.data');
 
Route::get('/contact', [GuestController::class, 'contact'])->name('contact');
Route::post('/inquiry', [GuestController::class, 'storeInquiry'])->name('inquiry.store');

Route::middleware('guest')->group(function () {

    Route::get('/login-admin-aisybina-export', function () {
        return view('login');
    })->name('login');
    Route::get('/login', function () {
        abort(404);
    });
    Route::post('/login', [AuthController::class, 'login']);
});



Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth');

Route::middleware('auth')
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/', fn () => redirect()->route('admin.dashboard'))->name('home');

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('/site-content', [SiteContentController::class, 'index'])->name('site-content.index');
        Route::put('/site-content/{table}', [SiteContentController::class, 'updateData'])->name('site-content.update');

        Route::get('/inquiries/export', [InquiryFormController::class, 'export'])->name('inquiries.export');
        Route::resource('inquiries', InquiryFormController::class)
            ->only(['index', 'show', 'destroy'])
            ->parameters(['inquiries' => 'id']);

        $crud = [
            'categories'     => CategoryController::class,
            'products'       => ProductController::class,
            'our-mission'    => OurMissionController::class,
            'our-value'      => OurValueController::class,
            'our-process'    => OurProcessController::class,
            'choose-us'      => ChooseUsController::class,
            'about-items'    => AboutItemController::class,
            'business-hours' => BusinessHourController::class,
        ];

        foreach ($crud as $uri => $controller) {
            Route::resource($uri, $controller)
                ->only(['index', 'show', 'store', 'update', 'destroy'])
                ->parameters([$uri => 'id']);
        }
    });
