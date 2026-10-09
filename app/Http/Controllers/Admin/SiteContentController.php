<?php

namespace App\Http\Controllers\Admin;

use App\View\Composers\MasterComposer;
use App\View\Composers\FooterViewComposer;
use App\View\Composers\ContactComposer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;

class SiteContentController extends Controller
{
    private const CACHE_CLEARERS = [
        'master'  => MasterComposer::class,
        'footer'  => FooterViewComposer::class,
        'contact' => ContactComposer::class,
    ];
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
        ]);
    }

    public function data(Request $request)
    {
        $tab = (string) $request->query('tab', 'master');
        $this->validateTable($tab);

        return response()->json([
            'success' => true,
            'data'    => DB::table($tab)->first(),
        ]);
    }

    public function updateData(Request $request, string $table)
    {
        $this->validateTable($table);

        $data = $request->validate($this->rules($table));

        $imageKeys = $this->imageKeys($table);

        foreach ($imageKeys as $key) {
            unset($data[$key]);
        }

        $existing = DB::table($table)->first();
        $base     = $this->basePath();
        $dir      = $base . '/images/website';

        $newFiles = [];
        $oldFiles = [];  

        DB::beginTransaction();

        try {
            if (! is_dir($dir)) {
                mkdir($dir, 0755, true);
            }

            foreach ($imageKeys as $key) {
                if (! $request->hasFile($key)) {
                    continue;
                }

                $image    = $request->file($key);
                $filename = Str::random(40) . '.' . $image->getClientOriginalExtension();

                $image->move($dir, $filename);

                $newFiles[]  = $dir . '/' . $filename;
                $data[$key]  = 'images/website/' . $filename;

                if ($existing && ! empty($existing->{$key})) {
                    $oldFiles[] = $base . '/' . ltrim($existing->{$key}, '/');
                }
            }

            $now = now();

            if ($existing) {
                DB::table($table)->update($data + ['updated_at' => $now]);
            } else {
                DB::table($table)->insert($data + ['created_at' => $now, 'updated_at' => $now]);
            }
            DB::afterCommit(function () use ($table) {
                try {
                    if (isset(self::CACHE_CLEARERS[$table])) {
                        self::CACHE_CLEARERS[$table]::clearCache();
                    }
                } catch (\Throwable $e) {
                    report($e); 
                }
            });
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();

            foreach ($newFiles as $file) {
                if (is_file($file)) {
                    @unlink($file);
                }
            }

            report($e);

            return response()->json([
                'message' => 'Gagal menyimpan data.',
                'error'   => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }

        foreach ($oldFiles as $file) {
            if (is_file($file)) {
                @unlink($file);
            }
        }
        
        return response()->json([
            'message' => 'Data berhasil disimpan.',
            'data'    => DB::table($table)->first(),
        ]);
    }

    private function rules(string $table): array
    {
        $rules = [];

        foreach ($this->tabs()[$table]['fields'] as [$key, , $type]) {
            $rules[$key] = match ($type) {
                'image'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
                'textarea' => 'nullable|string',
                default    => 'nullable|string|max:255',
            };
        }

        return $rules;
    }

    private function imageKeys(string $table): array
    {
        $images = array_filter($this->tabs()[$table]['fields'], fn ($f) => $f[2] === 'image');

        return array_values(array_column($images, 0));
    }

    private function basePath(): string
    {
        return app()->environment('production')
            ? '/home/aisy8672/public_html'
            : public_path();
    }

    private function validateTable(string $table): void
    {
        if (! array_key_exists($table, $this->tabs())) {
            abort(404, 'Table tidak ditemukan.');
        }
    }
}