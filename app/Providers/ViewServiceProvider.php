<?php

namespace App\Providers;

use App\View\Composers\MasterComposer;
use App\View\Composers\FooterViewComposer;
use App\View\Composers\ContactComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $pages = ['home', 'about', 'products', 'contact', 'categories', 'detail'];

        View::composer($pages, MasterComposer::class);
        View::composer($pages, FooterViewComposer::class);
        View::composer($pages, ContactComposer::class);
    }
}