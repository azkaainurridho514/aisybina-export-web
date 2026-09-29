<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SiteContentController extends Controller
{
   
    private function tabs(): array
    {
        return [
            'master' => ['label' => 'Home', 'fields' => [
                ['website_name', 'Nama Website', 'text'],
                ['website_description', 'Deskripsi Website', 'textarea'],
                ['website_slug', 'Slug Website', 'text'],
                ['logo', 'Logo Website', 'image'],
                ['heading', 'Judul Utama', 'textarea'],
                ['about_heading', 'Judul Section Tentang Kami', 'text'],
                ['about_description', 'Deskripsi Section Tentang Kami', 'textarea'],
                ['category_heading', 'Judul Section Produk', 'text'],
                ['category_description', 'Deskripsi Section Produk', 'textarea'],
                ['choose_us_heading', 'Judul Mengapa Memilih Kami', 'text'],
                ['our_process', 'Judul Proses Kami', 'text'],
            ]],
            'about' => ['label' => 'About', 'fields' => [
                ['intro_title', 'Judul Tentang Perusahaan', 'text'],
                ['intro_description', 'Deskripsi Tentang Perusahaan', 'textarea'],
                ['image_intro', 'Gambar Tentang Perusahaan', 'image'],
                ['vision_description', 'Deskripsi Visi', 'textarea'],
                ['image_vision', 'Gambar Visi', 'image'],
                ['image_mission', 'Gambar Misi', 'image'],
                ['value_description', 'Deskripsi Value Kami', 'textarea'],
                ['image_value', 'Gambar Value Kami', 'image'],
            ]],
            'ask_us' => ['label' => 'Ask Us', 'fields' => [
                ['ask_us_title', 'Label Kecil', 'text'],
                ['ask_us_heading', 'Judul', 'text'],
                ['ask_us_description', 'Deskripsi', 'textarea'],
                ['ask_us_button', 'Teks Tombol', 'text'],
            ]],
            'global_reach' => ['label' => 'Global Reach', 'fields' => [
                ['global_reach_title', 'Label Kecil', 'text'],
                ['global_reach_description', 'Deskripsi', 'textarea'],
                ['global_reach_image', 'Gambar Utama', 'image'],
                ['global_reach_item_1', 'Item 1 — Teks', 'text'],
                ['global_reach_icon_item_1', 'Item 1 — Ikon', 'image'],
                ['global_reach_item_2', 'Item 2 — Teks', 'text'],
                ['global_reach_icon_item_2', 'Item 2 — Ikon', 'image'],
                ['global_reach_item_3', 'Item 3 — Teks', 'text'],
                ['global_reach_icon_item_3', 'Item 3 — Ikon', 'image'],
            ]],
            'footer' => ['label' => 'Footer', 'fields' => [
                ['footer_home_heading', 'Judul Footer halaman Home', 'text'],
                ['footer_home_subheading', 'Subjudul Footer halaman Home', 'textarea'],
                ['footer_home_button', 'Teks Tombol Footer halaman Home', 'text'],
                ['footer_product_heading', 'Judul Footer Halaman Produk', 'text'],
                ['footer_product_subheading', 'Subjudul Footer Halaman Produk', 'textarea'],
                ['footer_product_button', 'Teks Tombol Footer Halaman Produk', 'text'],
            ]],
            'contact' => ['label' => 'Contact', 'fields' => [
                ['product_heading', 'Judul Halaman Produk', 'text'],
                ['product_subheading', 'Subjudul Halaman Produk', 'textarea'],
                ['heading', 'Judul Halaman Kontak', 'text'],
                ['subheading', 'Subjudul Halaman Kontak', 'textarea'],
                ['email', 'Email', 'text'],
                ['whatsapp', 'Nomor WhatsApp', 'text'],
                ['location', 'Lokasi', 'text'],
                ['instagram', 'Tautan Instagram', 'text'],
                ['facebook', 'Tautan Facebook', 'text'],
                ['tiktok', 'Tautan TikTok', 'text'],
                ['youtube', 'Tautan YouTube', 'text'],
            ]],
        ];
    }

    public function index(Request $request)
    {
        $tabs   = $this->tabs();
        $active = (string) $request->query('tab', 'master');

        if (! isset($tabs[$active])) {
            $active = 'master';
        }

        return view('admin.site-content.index', [
            'tabs'   => $tabs,
            'active' => $active,
            'data'   => DB::table($active)->first(),
        ]);
    }

    public function updateData(Request $request, string $table)
    {
        $this->validateTable($table);

        $data = $request->validate([
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'website_name' => 'nullable|string',
            'website_description' => 'nullable|string',
            'website_slug' => 'nullable|string',
            'heading' => 'nullable|string',
            'about_heading' => 'nullable|string',
            'about_description' => 'nullable|string',
            'category_heading' => 'nullable|string',
            'category_description' => 'nullable|string',
            'choose_us_heading' => 'nullable|string',
            'our_process' => 'nullable|string',

            'ask_us_title' => 'nullable|string',
            'ask_us_heading' => 'nullable|string',
            'ask_us_description' => 'nullable|string',
            'ask_us_button' => 'nullable|string',

            'intro_title' => 'nullable|string',
            'intro_description' => 'nullable|string',
            'image_intro' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'vision_heading' => 'nullable|string',
            'vision_description' => 'nullable|string',
            'image_vision' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'mission_heading' => 'nullable|string',
            'image_mission' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'value_heading' => 'nullable|string',
            'value_description' => 'nullable|string',
            'image_value' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',

            'global_reach_title' => 'nullable|string',
            'global_reach_description' => 'nullable|string',
            'global_reach_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'global_reach_item_1' => 'nullable|string',
            'global_reach_item_2' => 'nullable|string',
            'global_reach_item_3' => 'nullable|string',
            'global_reach_icon_item_1' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'global_reach_icon_item_2' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'global_reach_icon_item_3' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',

            'footer_home_heading' => 'nullable|string',
            'footer_home_subheading' => 'nullable|string',
            'footer_home_button' => 'nullable|string',
            'footer_product_heading' => 'nullable|string',
            'footer_product_subheading' => 'nullable|string',
            'footer_product_button' => 'nullable|string',

            'product_heading' => 'nullable|string',
            'product_subheading' => 'nullable|string',
            'email' => 'nullable|string',
            'whatsapp' => 'nullable|string',
            'tiktok' => 'nullable|string',
            'instagram' => 'nullable|string',
            'facebook' => 'nullable|string',
            'youtube' => 'nullable|string',
            'location' => 'nullable|string',
            'subheading' => 'nullable|string',
        ]);

       

        DB::beginTransaction();

        try {
            $existing = DB::table($table)->first();
            $isProduction = app()->environment('production');

            $imageFields = [
                'logo',
                'image_intro',
                'image_vision',
                'image_mission',
                'image_value',
                'global_reach_image',
                'global_reach_icon_item_1',
                'global_reach_icon_item_2',
                'global_reach_icon_item_3',
            ];
           $uploadPath = $isProduction
            ? '/home/aisy8672/public_html/images/website'
            : public_path('images/website');

            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            if ($existing) {
                foreach ($imageFields as $field) {
                    if ($request->hasFile($field)) {

                        $oldPath = $existing->{$field} ?? null;

                        if ($oldPath) {
                        $oldFilePath = $isProduction
                            ? '/home/aisy8672/public_html/' . $oldPath
                            : public_path($oldPath);

                            if (file_exists($oldFilePath)) {
                                unlink($oldFilePath);
                            }
                        }

                        $image = $request->file($field);

                        $filename = Str::random(40) . '.' . $image->getClientOriginalExtension();

                        $image->move($uploadPath, $filename);

                        $data[$field] = 'images/website/' . $filename;
                    }
                }
            } else {
              
                foreach ($imageFields as $field) {
                    if ($request->hasFile($field)) {

                        $image = $request->file($field);

                        $filename = Str::random(40) . '.' . $image->getClientOriginalExtension();

                        $image->move($uploadPath, $filename);

                        $data[$field] = 'images/website/' . $filename;
                    }
                }
            }

            foreach ($imageFields as $field) {
                if (!$request->hasFile($field)) {
                    unset($data[$field]);
                }
            }

            if (!$existing) {
                DB::table($table)->insert($data);
            } else {
                DB::table($table)->update($data);
            }

            DB::commit();

            return response()->json([
                'message' => 'Data berhasil disimpan.',
                'data' => DB::table($table)->first(),
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();

            return response()->json([
                'message' => 'Gagal menyimpan data.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    private function validateTable(string $table): void
    {
        if (! array_key_exists($table, $this->tabs())) {
            abort(404, 'Table tidak ditemukan.');
        }
    }
}