<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SiteContentController extends Controller
{
    /**
     * Allowed singleton tables.
     */
    private array $allowedTables = [
        'master',
        'ask_us',
        'global_reach',
        'footer',
        'contact',
    ];

    /**
     * Get singleton data.
     */
    public function getData(string $table)
    {
        $this->validateTable($table);

        $data = DB::table($table)->first();

        if (!$data) {
            return response()->json([
                'message' => 'Data tidak ditemukan.'
            ], 404);
        }

        return response()->json($data);
    }

    /**
     * Update singleton data.
     */
    public function updateData(Request $request, string $table)
    {
        $this->validateTable($table);

        $data = $request->validate([
            'icon' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'website_name' => 'nullable|string',
            'website_description' => 'nullable|string',
            'heading' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
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

            /*
            * Field yang berupa image.
            * Setiap field hanya menyimpan satu file.
            */
            $imageFields = [
                'icon',
                'image',
                'global_reach_image',
                'global_reach_icon_item_1',
                'global_reach_icon_item_2',
                'global_reach_icon_item_3',
            ];

            /*
            * Path folder upload.
            */
            $uploadPath = public_path('images/website');

            /*
            * Pastikan folder tersedia.
            */
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            /*
            * Kalau data sudah ada, proses image yang dikirim.
            *
            * Jika image tidak dikirim:
            * - image lama tetap dipertahankan.
            *
            * Jika image baru dikirim:
            * - hapus file lama.
            * - simpan file baru.
            * - update path di database.
            */
            if ($existing) {
                foreach ($imageFields as $field) {
                    if ($request->hasFile($field)) {

                        /*
                        * Hapus file lama.
                        */
                        $oldPath = $existing->{$field} ?? null;

                        if ($oldPath) {
                            $oldFilePath = public_path($oldPath);

                            if (file_exists($oldFilePath)) {
                                unlink($oldFilePath);
                            }
                        }

                        /*
                        * Upload file baru.
                        */
                        $image = $request->file($field);

                        $filename = Str::random(40) . '.' . $image->getClientOriginalExtension();

                        $image->move($uploadPath, $filename);

                        /*
                        * Simpan path relatif ke database.
                        */
                        $data[$field] = 'images/website/' . $filename;
                    }
                }
            } else {
                /*
                * Data belum ada.
                * Upload image yang dikirim.
                */
                foreach ($imageFields as $field) {
                    if ($request->hasFile($field)) {

                        $image = $request->file($field);

                        $filename = Str::random(40) . '.' . $image->getClientOriginalExtension();

                        $image->move($uploadPath, $filename);

                        $data[$field] = 'images/website/' . $filename;
                    }
                }
            }

            /*
            * Karena field image berupa file upload,
            * jangan sampai object UploadedFile masuk ke database.
            *
            * Hapus field image yang belum dikirim dari $data.
            * Dengan begitu, pada update image lama tetap dipertahankan.
            */
            foreach ($imageFields as $field) {
                if (!$request->hasFile($field)) {
                    unset($data[$field]);
                }
            }

            /*
            * Insert atau update data.
            */
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

    /**
     * Validate singleton table.
     */
    private function validateTable(string $table): void
    {
        if (!in_array($table, $this->allowedTables)) {
            abort(404, 'Table tidak ditemukan.');
        }
    }
}