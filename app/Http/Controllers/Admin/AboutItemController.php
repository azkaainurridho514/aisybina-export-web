<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutItem;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AboutItemController extends Controller
{
    public function getData()
    {
        return response()->json(
            AboutItem::orderBy('id')->get()
        );
    }

    public function show(string $id)
    {
        $data = AboutItem::find($id);

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

        $item = AboutItem::create([
            'id' => (string) Str::uuid(),
            'icon' => $data['icon'],
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
        ]);

        return response()->json([
            'message' => 'About item berhasil ditambahkan.',
            'data' => $item,
        ], 201);
    }

    public function update(Request $request, string $id)
    {
        $item = AboutItem::find($id);

        if (!$item) {
            return response()->json([
                'message' => 'Data tidak ditemukan.'
            ], 404);
        }

        $data = $request->validate([
            'icon' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $item->update($data);

        return response()->json([
            'message' => 'About item berhasil diperbarui.',
            'data' => $item->fresh(),
        ]);
    }

    public function destroy(string $id)
    {
        $item = AboutItem::find($id);

        if (!$item) {
            return response()->json([
                'message' => 'Data tidak ditemukan.'
            ], 404);
        }

        $item->delete();

        return response()->json([
            'message' => 'About item berhasil dihapus.',
            'id' => $id,
        ]);
    }
}