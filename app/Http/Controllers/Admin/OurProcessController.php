<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OurProcess;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OurProcessController extends Controller
{
    public function getData()
    {
        return response()->json(
            OurProcess::orderBy('created_at', 'asc')->get()
        );
    }

    public function show(string $id)
    {
        $data = OurProcess::find($id);

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
        ]);

        $process = OurProcess::create([
            'id' => (string) Str::uuid(),
            'title' => $data['title'],
        ]);

        return response()->json([
            'message' => 'Proses berhasil ditambahkan.',
            'data' => $process,
        ], 201);
    }

    public function update(Request $request, string $id)
    {
        $process = OurProcess::find($id);

        if (!$process) {
            return response()->json([
                'message' => 'Data tidak ditemukan.'
            ], 404);
        }

        $data = $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $process->update($data);

        return response()->json([
            'message' => 'Proses berhasil diperbarui.',
            'data' => $process->fresh(),
        ]);
    }

    public function destroy(string $id)
    {
        $process = OurProcess::find($id);

        if (!$process) {
            return response()->json([
                'message' => 'Data tidak ditemukan.'
            ], 404);
        }

        $process->delete();

        return response()->json([
            'message' => 'Proses berhasil dihapus.',
            'id' => $id,
        ]);
    }
}