<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\PaginatesAdminList;
use App\Http\Controllers\Controller;
use App\Models\OurMission;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OurMissionController extends Controller
{
    use PaginatesAdminList;

    /**
     * Halaman daftar (Blade, dirender server).
     */
    public function index()
    {
        $items = OurMission::orderBy('created_at', 'asc')
            ->paginate(10)
            ->withQueryString();

        if ($redirect = $this->lastPageRedirect($items, 'admin.our-mission.index')) {
            return $redirect;
        }

        return view('admin.our-mission.index', ['items' => $items]);
    }

    public function show(string $id)
    {
        $data = OurMission::find($id);

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
            'description' => 'required|string',
        ]);

        $mission = OurMission::create([
            'id' => (string) Str::uuid(),
            'description' => $data['description'],
        ]);

        return response()->json([
            'message' => 'Mission berhasil ditambahkan.',
            'data' => $mission,
        ], 201);
    }

    public function update(Request $request, string $id)
    {
        $mission = OurMission::find($id);

        if (!$mission) {
            return response()->json([
                'message' => 'Data tidak ditemukan.'
            ], 404);
        }

        $data = $request->validate([
            'description' => 'required|string',
        ]);

        $mission->update($data);

        return response()->json([
            'message' => 'Mission berhasil diperbarui.',
            'data' => $mission->fresh(),
        ]);
    }

    public function destroy(string $id)
    {
        $mission = OurMission::find($id);

        if (!$mission) {
            return response()->json([
                'message' => 'Data tidak ditemukan.'
            ], 404);
        }

        $mission->delete();

        return response()->json([
            'message' => 'Mission berhasil dihapus.',
            'id' => $id,
        ]);
    }
}