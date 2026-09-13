<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OurValue;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OurValueController extends Controller
{
    public function getData()
    {
        return response()->json(
            OurValue::orderBy('created_at', 'asc')->get()
        );
    }

    public function show(string $id)
    {
        $data = OurValue::find($id);

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
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $value = OurValue::create([
            'id' => (string) Str::uuid(),
            'title' => $data['title'],
            'description' => $data['description'],
        ]);

        return response()->json([
            'message' => 'Value berhasil ditambahkan.',
            'data' => $value,
        ], 201);
    }

    public function update(Request $request, string $id)
    {
        $value = OurValue::find($id);

        if (!$value) {
            return response()->json([
                'message' => 'Data tidak ditemukan.'
            ], 404);
        }

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);

        $value->update($data);

        return response()->json([
            'message' => 'Value berhasil diperbarui.',
            'data' => $value->fresh(),
        ]);
    }

    public function destroy(string $id)
    {
        $value = OurValue::find($id);

        if (!$value) {
            return response()->json([
                'message' => 'Data tidak ditemukan.'
            ], 404);
        }

        $value->delete();

        return response()->json([
            'message' => 'Value berhasil dihapus.',
            'id' => $id,
        ]);
    }
}