<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\OurProcess;
use Illuminate\Http\Request;
use App\Models\ChooseUs;
use App\Models\AboutItem;
use App\Models\BusinessHour;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function getData(string $page)
    {
        $data = [];
        switch ($page) {
            case "home":
                $data = [
                    'master' => DB::table('master')
                    ->select('logo', 'website_name', 'website_description', 
                    'heading', 'about_heading', "about_description",
                    "category_heading", 'category_description', 'choose_us_heading', 'our_process', 'website_slug'
                    )->first(),
                    'ask_us' => DB::table('ask_us')->select('ask_us_title',
                    "ask_us_heading", 'ask_us_description', 'ask_us_button')
                    ->first(),
                    'global_reach' => DB::table('global_reach')->select('global_reach_title', 'global_reach_description', 'global_reach_image', 'global_reach_item_1', 'global_reach_item_2','global_reach_item_3', 'global_reach_icon_item_1', 'global_reach_icon_item_2', 'global_reach_icon_item_3')
                    ->first(),
                    'footer' => DB::table('footer')->select('footer_home_heading', 'footer_home_subheading', 'footer_home_button')
                    ->first(),
                    'products' => Product::with(['category', 'images'])->inRandomOrder()->limit(8)->get(),
                    'about_item'  => AboutItem::oldest()->get(),
                    'our_process' => OurProcess::oldest()->get(),
                    'choose_us'   => ChooseUs::oldest()->get(),
                    'contact' => DB::table('contact')->select('email', 'whatsapp', 'tiktok', 'instagram', 'facebook', 'youtube', 'location')->first(),
                ];
                break;
            case "about":
                $data = [
                    'page_desc' => DB::table('contact')->select('email', 'whatsapp', 'tiktok', 'instagram', 'facebook', 'youtube', 'location')->first(),
                    'master' => DB::table('master')
                    ->select('logo', 'website_name', 'website_slug', 'about_heading', "about_description")->first(),
                    'about' => DB::table('about')->first(),
                    'about_missions' => DB::table('about_missions')->get(),
                    'about_values' => DB::table('about_values')->get(),
                ];
                break;
            case "product":
                $data = [
                    'page_desc' => DB::table('contact')->select("product_heading", "product_subheading", 'email', 'whatsapp', 'tiktok', 'instagram', 'facebook', 'youtube', 'location')->first(),
                    'footer' => DB::table('footer')->select('footer_product_heading', 'footer_product_subheading', 'footer_product_button')
                    ->first(),
                    'master' => DB::table('master')
                    ->select('logo', 'website_name', 'website_slug')->first(),
                ];
                break;
            case "contact":
                $data = [
                    'bussiness_hours' => BusinessHour::oldest()->get(),
                    'master' => DB::table('master')
                    ->select('logo', 'website_name', 'website_slug')->first(),
                    'contact' => DB::table('contact')->select('heading','subheading','email', 'whatsapp', 'tiktok', 'instagram', 'facebook', 'youtube', 'location')->first(),
                ];
                break;
            default:
                abort(404);
        }
        return response()->json($data);
    }
}