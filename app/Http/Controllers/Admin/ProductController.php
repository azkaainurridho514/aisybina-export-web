<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Get all products.
     */
    public function getData(Request $request)
    {
        $search = $request->query('search');
        $perPage = $request->query('per_page', 10);

        $products = Product::with('category')
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->latest()
            ->paginate($perPage);

        return response()->json($products);
    }

    /**
     * Get one product.
     */
    public function show(string $id)
    {
        $product = Product::with('category', 'images')->find($id);

        if (!$product) {
            return response()->json([
                'message' => 'Data tidak ditemukan.'
            ], 404);
        }

        return response()->json($product);
    }

    /**
     * Create product.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id' => 'required|uuid|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        DB::beginTransaction();

        try {
            $product = Product::create([
                'id' => (string) Str::uuid(),
                'category_id' => $data['category_id'],
                'name' => $data['name'],
                'description' => $data['description'] ?? null,
            ]);

            /**
             * Upload images ke public/products.
             */
            if ($request->hasFile('images')) {
                $uploadPath = public_path('images/products');

                // Pastikan folder products tersedia.
                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }

                foreach ($request->file('images') as $image) {
                    $filename = Str::random(40) . '.' . $image->getClientOriginalExtension();

                    $image->move($uploadPath, $filename);

                    ProductImage::create([
                        'id' => (string) Str::uuid(),
                        'product_id' => $product->id,
                        'path' => 'images/products/' . $filename,
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'message' => 'Produk berhasil ditambahkan.',
                'data' => $product->fresh()->load('category', 'images'),
            ], 201);

        } catch (\Throwable $e) {
            DB::rollBack();

            return response()->json([
                'message' => 'Gagal menambahkan produk.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update product.
     *
     * Jika images dikirim:
     * - hapus semua image lama
     * - hapus file lama dari public/products
     * - simpan image baru
     *
     * Jika images tidak dikirim:
     * - image lama tetap dipertahankan
     */
    public function update(Request $request, string $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'message' => 'Data tidak ditemukan.'
            ], 404);
        }

        $data = $request->validate([
            'category_id' => 'required|uuid|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        DB::beginTransaction();

        try {
            /**
             * Update data product.
             */
            $product->update([
                'category_id' => $data['category_id'],
                'name' => $data['name'],
                'description' => $data['description'] ?? null,
            ]);

            /**
             * Jika ada images baru:
             * hapus image lama lalu upload image baru.
             */
            if ($request->hasFile('images')) {
                $oldImages = $product->images()->get();

                /**
                 * Hapus file dan record image lama.
                 */
                foreach ($oldImages as $oldImage) {
                    $path = $oldImage->getRawOriginal('path');

                    if ($path) {
                        $oldImagePath = public_path($path);

                        if (file_exists($oldImagePath)) {
                            unlink($oldImagePath);
                        }
                    }

                    $oldImage->delete();
                }

                /**
                 * Upload image baru ke public/products.
                 */
                $uploadPath = public_path('images/products');

                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }

                foreach ($request->file('images') as $image) {
                    $filename = Str::random(40) . '.' . $image->getClientOriginalExtension();

                    $image->move($uploadPath, $filename);

                    ProductImage::create([
                        'id' => (string) Str::uuid(),
                        'product_id' => $product->id,
                        'path' => 'images/products/' . $filename,
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'message' => 'Produk berhasil diperbarui.',
                'data' => $product->fresh()->load('category', 'images'),
            ]);

        } catch (\Throwable $e) {
            DB::rollBack();

            return response()->json([
                'message' => 'Gagal memperbarui produk.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Delete product.
     *
     * - hapus semua file image dari public/products
     * - hapus record image
     * - hapus product
     */
    public function destroy(string $id)
    {
        $product = Product::with('images')->find($id);

        if (!$product) {
            return response()->json([
                'message' => 'Data tidak ditemukan.'
            ], 404);
        }

        DB::beginTransaction();

        try {
            /**
             * Hapus semua image product.
             */
            foreach ($product->images as $image) {
                $path = $image->getRawOriginal('path');

                if ($path) {
                    $imagePath = public_path($path);

                    if (file_exists($imagePath)) {
                        unlink($imagePath);
                    }
                }

                $image->delete();
            }

            /**
             * Hapus product.
             */
            $product->delete();

            DB::commit();

            return response()->json([
                'message' => 'Produk berhasil dihapus.',
                'id' => $id,
            ]);

        } catch (\Throwable $e) {
            DB::rollBack();

            return response()->json([
                'message' => 'Gagal menghapus produk.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}

