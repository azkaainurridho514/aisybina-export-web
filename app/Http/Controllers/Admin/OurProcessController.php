<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\PaginatesAdminList;
use App\Http\Controllers\Controller;
use App\Models\OurProcess;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OurProcessController extends Controller
{
    use PaginatesAdminList;

    /**
     * Halaman daftar (Blade, dirender server).
     */
    public function index()
    {
        $items = OurProcess::orderBy('created_at', 'asc')
            ->paginate(10)
            ->withQueryString();

        if ($redirect = $this->lastPageRedirect($items, 'admin.our-process.index')) {
            return $redirect;
        }

        return view('admin.our-process.index', ['items' => $items]);
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