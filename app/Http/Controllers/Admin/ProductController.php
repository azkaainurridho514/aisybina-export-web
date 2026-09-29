<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\PaginatesAdminList;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    use PaginatesAdminList;
    public function index(Request $request)
    {
        $search = trim((string) $request->query('search', ''));

        $products = Product::with(['category', 'images'])
            ->when($search !== '', function ($query) use ($search) {
                $query->where('name', 'like', '%' . addcslashes($search, '%_\\') . '%');
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        if ($redirect = $this->lastPageRedirect($products, 'admin.products.index', ['search' => $search])) {
            return $redirect;
        }

        return view('admin.products.index', [
            'products'   => $products,
            'search'     => $search,
            'categories' => Category::orderBy('name')->get(['id', 'name']),
        ]);
    }

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

