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
use App\Http\Controllers\Admin\ChooseUsController;
use App\Http\Controllers\Admin\AboutItemController;


/*
|--------------------------------------------------------------------------
| Public Pages
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('index');
});
    
Route::get('/about', function () {
    return view('about');
});
Route::get('/products', function () {
    return view('products');
});

Route::get('/contact', function () {
    return view('contact');
});


/*
|--------------------------------------------------------------------------
| Authentication Pages
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {

    Route::get('/login-admin-aisybina-export', function () {
        return view('login');
    })->name('login');
    Route::get('/login', function () {
        abort(404);
    });
    Route::post('/login', [AuthController::class, 'login']);
});


/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/


Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth');

/*
|--------------------------------------------------------------------------
| Public AJAX / API
|--------------------------------------------------------------------------
*/

Route::get('/get-data/master/{page}', [HomeController::class, 'getData']);

Route::get('/get-data/products', [ProductPageController::class, 'getData']);

Route::post('/inquiry', [InquiryFormController::class, 'store']);


/*
|--------------------------------------------------------------------------
| Admin Page
|--------------------------------------------------------------------------
*/

Route::get('/admin', function () {
    return view('admin');
})->middleware('auth');


/*
|--------------------------------------------------------------------------
| Admin AJAX / Data
|--------------------------------------------------------------------------
*/

Route::middleware('auth')
    ->prefix('admin')
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Dashboard
        |--------------------------------------------------------------------------
        */

        Route::get('/dashboard', [
            DashboardController::class,
            'getData'
        ]);


        /*
        |--------------------------------------------------------------------------
        | Categories
        |--------------------------------------------------------------------------
        */

        Route::get('/categories', [
            CategoryController::class,
            'getData'
        ]);

        Route::get('/categories/{id}', [
            CategoryController::class,
            'show'
        ]);

        Route::post('/categories', [
            CategoryController::class,
            'store'
        ]);

        Route::put('/categories/{id}', [
            CategoryController::class,
            'update'
        ]);

        Route::delete('/categories/{id}', [
            CategoryController::class,
            'destroy'
        ]);


        /*
        |--------------------------------------------------------------------------
        | Products
        |--------------------------------------------------------------------------
        */

        Route::get('/products', [
            ProductController::class,
            'getData'
        ]);

        Route::get('/products/{id}', [
            ProductController::class,
            'show'
        ]);

        Route::post('/products', [
            ProductController::class,
            'store'
        ]);

        Route::put('/products/{id}', [
            ProductController::class,
            'update'
        ]);

        Route::delete('/products/{id}', [
            ProductController::class,
            'destroy'
        ]);


        /*
        |--------------------------------------------------------------------------
        | Inquiries
        |--------------------------------------------------------------------------
        */

        Route::get('/inquiries', [
            InquiryFormController::class,
            'getData'
        ]);

        Route::get('/inquiries/{id}', [
            InquiryFormController::class,
            'show'
        ]);

        Route::delete('/inquiries/{id}', [
            InquiryFormController::class,
            'destroy'
        ]);


        /*
        |--------------------------------------------------------------------------
        | Business Hours
        |--------------------------------------------------------------------------
        */

        Route::get('/business-hours', [
            BusinessHourController::class,
            'getData'
        ]);

        Route::get('/business-hours/{id}', [
            BusinessHourController::class,
            'show'
        ]);

        Route::post('/business-hours', [
            BusinessHourController::class,
            'store'
        ]);

        Route::put('/business-hours/{id}', [
            BusinessHourController::class,
            'update'
        ]);

        Route::delete('/business-hours/{id}', [
            BusinessHourController::class,
            'destroy'
        ]);


        /*
        |--------------------------------------------------------------------------
        | Our Process
        |--------------------------------------------------------------------------
        */

        Route::get('/our-process', [
            OurProcessController::class,
            'getData'
        ]);

        Route::get('/our-process/{id}', [
            OurProcessController::class,
            'show'
        ]);

        Route::post('/our-process', [
            OurProcessController::class,
            'store'
        ]);

        Route::put('/our-process/{id}', [
            OurProcessController::class,
            'update'
        ]);

        Route::delete('/our-process/{id}', [
            OurProcessController::class,
            'destroy'
        ]);


        /*
        |--------------------------------------------------------------------------
        | Choose Us
        |--------------------------------------------------------------------------
        */

        Route::get('/choose-us', [
            ChooseUsController::class,
            'getData'
        ]);

        Route::get('/choose-us/{id}', [
            ChooseUsController::class,
            'show'
        ]);

        Route::post('/choose-us', [
            ChooseUsController::class,
            'store'
        ]);

        Route::put('/choose-us/{id}', [
            ChooseUsController::class,
            'update'
        ]);

        Route::delete('/choose-us/{id}', [
            ChooseUsController::class,
            'destroy'
        ]);


        /*
        |--------------------------------------------------------------------------
        | About Items
        |--------------------------------------------------------------------------
        */

        Route::get('/about-items', [
            AboutItemController::class,
            'getData'
        ]);

        Route::get('/about-items/{id}', [
            AboutItemController::class,
            'show'
        ]);

        Route::post('/about-items', [
            AboutItemController::class,
            'store'
        ]);

        Route::put('/about-items/{id}', [
            AboutItemController::class,
            'update'
        ]);

        Route::delete('/about-items/{id}', [
            AboutItemController::class,
            'destroy'
        ]);


        /*
        |--------------------------------------------------------------------------
        | Site Content
        |--------------------------------------------------------------------------
        */

        Route::get('/site-content/{table}', [
            SiteContentController::class,
            'getData'
        ]);

        Route::put('/site-content/{table}', [
            SiteContentController::class,
            'updateData'
        ]);
    });