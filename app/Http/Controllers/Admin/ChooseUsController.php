<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\PaginatesAdminList;
use App\Http\Controllers\Controller;
use App\Models\ChooseUs;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ChooseUsController extends Controller
{
    use PaginatesAdminList;

    public function index()
    {
        $items = ChooseUs::orderBy('created_at', 'asc')
            ->paginate(10)
            ->withQueryString();

        if ($redirect = $this->lastPageRedirect($items, 'admin.choose-us.index')) {
            return $redirect;
        }

        return view('admin.choose-us.index', ['items' => $items]);
    }

    public function show(string $id)
    {
        $data = ChooseUs::find($id);

        if (!$data) {
            return response()->json([
                'message' => 'Data tidak ditemukan.'
            ], 404);
        }

        return response()->json($data);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'icon' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $chooseUs = ChooseUs::create([
            'id' => (string) Str::uuid(),
            'icon' => $data['icon'],
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
        ]);

        return response()->json([
            'message' => 'Data berhasil ditambahkan.',
            'data' => $chooseUs,
        ], 201);
    }

    public function update(Request $request, string $id)
    {
        $chooseUs = ChooseUs::find($id);

        if (!$chooseUs) {
            return response()->json([
                'message' => 'Data tidak ditemukan.'
            ], 404);
        }

        $data = $request->validate([
            'icon' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $chooseUs->update($data);

        return response()->json([
            'message' => 'Data berhasil diperbarui.',
            'data' => $chooseUs->fresh(),
        ]);
    }

    public function destroy(string $id)
    {
        $chooseUs = ChooseUs::find($id);

        if (!$chooseUs) {
            return response()->json([
                'message' => 'Data tidak ditemukan.'
            ], 404);
        }

        $chooseUs->delete();

        return response()->json([
            'message' => 'Data berhasil dihapus.',
            'id' => $id,
        ]);
    }
}