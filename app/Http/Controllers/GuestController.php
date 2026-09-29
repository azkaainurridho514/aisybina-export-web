<?php

namespace App\Http\Controllers;

use App\Models\AboutItem;
use App\Models\BusinessHour;
use App\Models\Category;
use App\Models\ChooseUs;
use App\Models\InquiryForm;
use App\Models\OurProcess;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class GuestController extends Controller
{
    public function index(): View
    {
        $master = DB::table('master')->select(
            'logo', 'website_name', 'website_description',
            'heading', 'about_heading', 'about_description',
            'category_heading', 'category_description',
            'choose_us_heading', 'our_process', 'website_slug'
        )->first();

        $askUs = DB::table('ask_us')->select(
            'ask_us_title', 'ask_us_heading', 'ask_us_description', 'ask_us_button'
        )->first();

        $globalReach = DB::table('global_reach')->select(
            'global_reach_title', 'global_reach_description', 'global_reach_image',
            'global_reach_item_1', 'global_reach_item_2', 'global_reach_item_3',
            'global_reach_icon_item_1', 'global_reach_icon_item_2', 'global_reach_icon_item_3'
        )->first();

        $footer = DB::table('footer')->select(
            'footer_home_heading', 'footer_home_subheading', 'footer_home_button'
        )->first();

        $products = Product::with(['category', 'images'])->inRandomOrder()->limit(8)->get();
        $aboutItems = AboutItem::oldest()->get();
        $ourProcess = OurProcess::oldest()->get();
        $chooseUs = ChooseUs::oldest()->get();

        $contact = DB::table('contact')->select(
            'email', 'whatsapp', 'tiktok', 'instagram', 'facebook', 'youtube', 'location'
        )->first();
        
        return view('home', compact(
            'master', 'askUs', 'globalReach', 'footer',
            'products', 'aboutItems', 'ourProcess', 'chooseUs', 'contact'
        ));
    }

    public function about(): View
    {
        $pageDesc = DB::table('contact')->select(
            'email', 'whatsapp', 'tiktok', 'instagram', 'facebook', 'youtube', 'location'
        )->first();

        $master = DB::table('master')->select(
            'logo', 'website_name', 'website_slug', 'about_heading', 'about_description'
        )->first();

        $about = DB::table('about')->first();
        $aboutMissions = DB::table('about_missions')->get();
        $aboutValues = DB::table('about_values')->get();

        return view('about', compact('pageDesc', 'master', 'about', 'aboutMissions', 'aboutValues'));
    }

    public function products(): View
    {
        $pageDesc = DB::table('contact')->select(
            'product_heading', 'product_subheading',
            'email', 'whatsapp', 'tiktok', 'instagram', 'facebook', 'youtube', 'location'
        )->first();

        $footer = DB::table('footer')->select(
            'footer_product_heading', 'footer_product_subheading', 'footer_product_button'
        )->first();

        $master = DB::table('master')->select('logo', 'website_name', 'website_slug')->first();

        return view('products', compact('pageDesc', 'footer', 'master'));
    }

    public function productsData(): JsonResponse
    {
        return response()->json([
            'categories' => Category::orderBy('name')->get(),
            'products' => Product::with(['category', 'images'])->get(),
        ]);
    }

    public function contact(): View
    {
        $businessHours = BusinessHour::oldest()->get();
        $master = DB::table('master')->select('logo', 'website_name', 'website_slug')->first();

        $contact = DB::table('contact')->select(
            'heading', 'subheading', 'email', 'whatsapp', 'tiktok', 'instagram', 'facebook', 'youtube', 'location'
        )->first();

        $businessHoursLines = $this->groupBusinessHours($businessHours);

        return view('contact', compact('master', 'contact', 'businessHoursLines'));
    }


    public function storeInquiry(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'fullname' => 'required|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'email' => 'required|email|max:255',
            'whatsapp' => 'nullable|string|max:50',
            'country' => 'nullable|string|max:100',
            'product_interested' => 'nullable|string|max:255',
            'estimated_quantity' => 'nullable|string|max:100',
            'message' => 'required|string',
        ]);


        InquiryForm::create($validated);

        return response()->json([
            'message' => 'Your inquiry has been successfully submitted. We will contact you shortly.',
        ]);
    }

    private function groupBusinessHours(Collection $businessHours): array
    {
        $dayOrder = [
            'senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu', 'minggu',
            'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday',
        ];

        $normalize = fn (?string $day) => strtolower(str_replace(' ', '', $day ?? ''));
        $isValidDay = fn (?string $day) => in_array($normalize($day), $dayOrder, true);

        $standard = $businessHours->filter(fn ($bh) => $isValidDay($bh->day))->values();
        $custom = $businessHours->filter(fn ($bh) => ! $isValidDay($bh->day))->values();

        $sorted = $standard->sortBy(
            fn ($bh) => array_search($normalize($bh->day), $dayOrder)
        )->values();

        $groups = [];
        foreach ($sorted as $bh) {
            $lastKey = count($groups) - 1;
            $last = $lastKey >= 0 ? $groups[$lastKey] : null;

            $currentIndex = array_search($normalize($bh->day), $dayOrder);
            $lastIndex = $last ? array_search($normalize($last['end']), $dayOrder) : null;

            $isConsecutive = $last && ($lastIndex + 1 === $currentIndex);
            $isSameTime = $last
                && $last['start_time'] === $bh->start_time
                && $last['end_time'] === $bh->end_time;

            if ($last && $isConsecutive && $isSameTime) {
                $groups[$lastKey]['end'] = $bh->day;
            } else {
                $groups[] = [
                    'start' => $bh->day,
                    'end' => $bh->day,
                    'start_time' => $bh->start_time,
                    'end_time' => $bh->end_time,
                ];
            }
        }

        $lines = [];

        foreach ($groups as $g) {
            $label = $g['start'] === $g['end']
                ? $g['start']
                : "{$g['start']} \u{2013} {$g['end']}";
            $lines[] = "{$label}, {$g['start_time']} \u{2013} {$g['end_time']} WIB";
        }

        foreach ($custom as $bh) {
            $lines[] = ($bh->start_time && $bh->end_time)
                ? "{$bh->day}, {$bh->start_time} \u{2013} {$bh->end_time} WIB"
                : "{$bh->day}: Closed";
        }

        return $lines;
    }
}