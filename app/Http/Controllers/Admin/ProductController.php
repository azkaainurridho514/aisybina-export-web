<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Option;
use App\Models\Product;

class ProductController extends Controller
{
    
    public function index()
    {   
        $categories = Category::latest()->get();
        return view('admin.products.index', compact('categories'));
    }

    public function data(Request $request)
    {
        $search = trim((string) $request->query('search', ''));

        $products = Product::with(['category', 'images'])
            ->when($search !== '', function ($query) use ($search) {
                $query->where(
                    'name',
                    'like',
                    '%' . addcslashes($search, '%_\\') . '%'
                );
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return response()->json([
            'success' => true,
            'data' => $products,
        ]);
    }

    public function show(string $id)
    {
        $product = Product::with('category', 'images', 'options')->find($id);

        if (!$product) {
            return response()->json([
                'message' => 'Data tidak ditemukan.'
            ], 404);
        }

        return response()->json($product);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id' => 'required|uuid|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'options'               => 'nullable|array',
            'options.*.id'          => 'nullable|uuid',
            'options.*.title'       => 'nullable|string|max:255',
            'options.*.description' => 'nullable|string',
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

            $product->saveOptions($data['options'] ?? []);

            if ($request->hasFile('images')) {

                $isProduction = app()->environment('production');

                $uploadPath = $isProduction
                    ? '/home/aisy8672/public_html/images/products'
                    : public_path('images/products');

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
            'options'               => 'nullable|array',
            'options.*.id'          => 'nullable|uuid',
            'options.*.title'       => 'nullable|string|max:255',
            'options.*.description' => 'nullable|string',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        DB::beginTransaction();

        try {
            $isProduction = app()->environment('production');
     
            $product->update([
                'category_id' => $data['category_id'],
                'name' => $data['name'],
                'description' => $data['description'] ?? null,
            ]);
            $product->saveOptions($data['options'] ?? []);

      
            if ($request->hasFile('images')) {
                $oldImages = $product->images()->get();

                foreach ($oldImages as $oldImage) {
                    $path = $oldImage->getRawOriginal('path');

                    if ($path) {
                        $oldImagePath = $isProduction
                        ? '/home/aisy8672/public_html/' . $path
                        : public_path($path);

                        if (file_exists($oldImagePath)) {
                            unlink($oldImagePath);
                        }
                    }

                    $oldImage->delete();
                }

                $uploadPath = $isProduction
                    ? '/home/aisy8672/public_html/images/products'
                    : public_path('images/products');

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
             $isProduction = app()->environment('production');
 
            foreach ($product->images as $image) {
                $path = $image->getRawOriginal('path');

                if ($path) {
                    $imagePath = $isProduction
                        ? '/home/aisy8672/public_html/' . $path
                        : public_path($path);

                    if (file_exists($imagePath)) {
                        unlink($imagePath);
                    }
                }

                $image->delete();
            }
            $optionIds = $product->options()->pluck('options.id');
            $product->options()->detach();
            Option::whereIn('id', $optionIds)->delete();
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

