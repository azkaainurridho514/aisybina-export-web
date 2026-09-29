<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private const PER_PAGE = 10;

    public function index(Request $request)
    {
        if ($request->expectsJson()) {
            return $this->getData($request);
        }

        $search = trim((string) $request->query('search', ''));

        $categories = Category::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where('name', 'like', '%' . addcslashes($search, '%_\\') . '%');
            })
            ->latest()
            ->paginate(self::PER_PAGE)
            ->withQueryString();

        if ($categories->isEmpty() && $categories->currentPage() > 1) {
            return redirect()->route('admin.categories.index', array_filter([
                'search' => $search,
                'page'   => $categories->lastPage(),
            ]));
        }

        return view('admin.categories.index', [
            'categories' => $categories,
            'search'     => $search,
        ]);
    }

    protected function getData(Request $request)
    {
        $search  = $request->query('search');
        $perPage = min(max((int) $request->query('per_page', 10), 1), 100);

        $data = Category::when($search, function ($query, $search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->latest()
            ->paginate($perPage);

        return response()->json($data);
    }

    public function show(string $id)
    {
        $category = Category::find($id);

        if (! $category) {
            return response()->json(['message' => 'Data tidak ditemukan.'], 404);
        }

        return response()->json($category);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $category = Category::create($data);

        return response()->json([
            'message' => 'Kategori berhasil ditambahkan.',
            'data'    => $category,
        ], 201);
    }

    public function update(Request $request, string $id)
    {
        $category = Category::find($id);

        if (! $category) {
            return response()->json(['message' => 'Data tidak ditemukan.'], 404);
        }

        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $category->update($data);

        return response()->json([
            'message' => 'Kategori berhasil diperbarui.',
            'data'    => $category->fresh(),
        ]);
    }

    public function destroy(string $id)
    {
        $category = Category::find($id);

        if (! $category) {
            return response()->json(['message' => 'Data tidak ditemukan.'], 404);
        }

        if ($category->products()->exists()) {
            return response()->json([
                'message' => 'Kategori masih dipakai oleh produk. Pindahkan atau hapus produknya terlebih dahulu.',
            ], 422);
        }

        $category->delete();

        return response()->json([
            'message' => 'Kategori berhasil dihapus.',
            'id'      => $id,
        ]);
    }
}
