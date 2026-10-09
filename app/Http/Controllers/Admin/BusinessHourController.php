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
    public function index()
    {
        return view('admin.business-hours.index');
    }

    public function data()
    {
        $items = BusinessHour::orderBy('created_at', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $items,
        ]);
    }

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