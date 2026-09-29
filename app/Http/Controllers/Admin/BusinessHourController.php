<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\PaginatesAdminList;
use App\Http\Controllers\Controller;
use App\Models\BusinessHour;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BusinessHourController extends Controller
{
    use PaginatesAdminList;

    /**
     * Halaman daftar (Blade, dirender server).
     */
    public function index()
    {
        $items = BusinessHour::orderBy('id')
            ->paginate(10)
            ->withQueryString();

        if ($redirect = $this->lastPageRedirect($items, 'admin.business-hours.index')) {
            return $redirect;
        }

        return view('admin.business-hours.index', ['items' => $items]);
    }

    /**
     * Get one business hour.
     */
    public function show(string $id)
    {
        $businessHour = BusinessHour::find($id);

        if (!$businessHour) {
            return response()->json([
                'message' => 'Data tidak ditemukan.'
            ], 404);
        }

        return response()->json($businessHour);
    }

    /**
     * Create business hour.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'day' => 'required|string|max:50',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
        ]);

        $businessHour = BusinessHour::create([
            'id' => (string) Str::uuid(),
            'day' => $data['day'],
            'start_time' => $data['start_time'],
            'end_time' => $data['end_time'],
        ]);

        return response()->json([
            'message' => 'Jam operasional berhasil ditambahkan.',
            'data' => $businessHour,
        ], 201);
    }

    /**
     * Update business hour.
     */
    public function update(Request $request, string $id)
    {
        $businessHour = BusinessHour::find($id);

        if (!$businessHour) {
            return response()->json([
                'message' => 'Data tidak ditemukan.'
            ], 404);
        }

        $data = $request->validate([
            'day' => 'required|string|max:50',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
        ]);

        $businessHour->update($data);

        return response()->json([
            'message' => 'Jam operasional berhasil diperbarui.',
            'data' => $businessHour->fresh(),
        ]);
    }

    /**
     * Delete business hour.
     */
    public function destroy(string $id)
    {
        $businessHour = BusinessHour::find($id);

        if (!$businessHour) {
            return response()->json([
                'message' => 'Data tidak ditemukan.'
            ], 404);
        }

        $businessHour->delete();

        return response()->json([
            'message' => 'Jam operasional berhasil dihapus.',
            'id' => $id,
        ]);
    }
}