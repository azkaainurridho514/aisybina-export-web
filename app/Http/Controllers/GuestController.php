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

        $askUs = DB::table('ask_us')->select(
            'ask_us_title', 'ask_us_heading', 'ask_us_description', 'ask_us_button'
        )->first();

        $globalReach = DB::table('global_reach')->select(
            'global_reach_title', 'global_reach_description', 'global_reach_image',
            'global_reach_item_1', 'global_reach_item_2', 'global_reach_item_3',
            'global_reach_icon_item_1', 'global_reach_icon_item_2', 'global_reach_icon_item_3'
        )->first();

        $products = Product::with(['category', 'images'])->inRandomOrder()->limit(8)->get();
        $aboutItems = AboutItem::oldest()->get();
        $ourProcess = OurProcess::oldest()->get();
        $chooseUs = ChooseUs::oldest()->get();
        
        return view('home', compact('askUs', 'globalReach', 'products', 'aboutItems', 'ourProcess', 'chooseUs',
        ));
    }

    public function about(): View
    {

        $about = DB::table('about')->first();
        $aboutMissions = DB::table('about_missions')->get();
        $aboutValues = DB::table('about_values')->get();

        return view('about', compact('about', 'aboutMissions', 'aboutValues'));
    }

    public function products(): View
    {
        $categories = Category::latest()->get();

        $products = Product::with('images')
            ->inRandomOrder()
            ->get()
            ->groupBy('category_id')
            ->flatMap(fn ($group) => $group->take(6));

        return view('products', compact('categories', 'products'));
    }

    public function category(Category $category): View{
        $products = Product::with('images')
            ->where('category_id', $category->id)
            ->inRandomOrder()
            ->get();
        return view('categories', compact('products', 'category'));
    }
        
    public function product(Product $product): View
    {
        $product->load('options');

        $options = json_decode(json_encode(
            $product->options
                ->map(fn ($option) => [
                    'title'       => $option->title,
                    'description' => $option->description,
                ])
                ->all()
        ));

        $related = Product::with('images')
            ->where('category_id', $product->category_id)
            ->whereKeyNot($product->getKey())
            ->latest()
            ->take(3)
            ->get();

        return view('detail', compact('product', 'options', 'related'));
    }

    public function contact(): View
    {
        $businessHours = BusinessHour::oldest()->get();
        $businessHoursLines = $this->groupBusinessHours($businessHours);

        return view('contact', compact('businessHoursLines'));
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