<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Option;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OptionController extends Controller
{
    public function index()
    {
        return view('admin.option.index');
    }

    public function data(): JsonResponse
    {
        $options = Option::with('items:id,option_id,description')
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'data'    => $options,
        ]);
    }

    public function show(string $id): JsonResponse
    {
        $option = Option::with('items:id,option_id,description')->findOrFail($id);

        return response()->json([
            'success' => true,
            'data'    => $option,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $this->validated($request);

        $option = DB::transaction(function () use ($data) {
            $option = Option::create([
                'title'       => $data['title'],
                'description' => $data['description'],
            ]);

            $this->syncItems($option, $data['items']);

            return $option;
        });

        return response()->json([
            'success' => true,
            'message' => 'Option berhasil ditambahkan.',
            'data'    => $option->load('items:id,option_id,description'),
        ], 201);
    }

    public function update(Request $request, string $id): JsonResponse
    {
        $option = Option::findOrFail($id);
        $data   = $this->validated($request);

        DB::transaction(function () use ($option, $data) {
            $option->update([
                'title'       => $data['title'],
                'description' => $data['description'],
            ]);

            $this->syncItems($option, $data['items']);
        });

        return response()->json([
            'success' => true,
            'message' => 'Option berhasil diperbarui.',
            'data'    => $option->load('items:id,option_id,description'),
        ]);
    }

    public function destroy(string $id): JsonResponse
    {

        $option = Option::findOrFail($id);

        $used = $option->productOptions()->count();
        if ($used > 0) {
            return response()->json([
                'success' => false,
                'message' => "Option masih dipakai oleh {$used} produk.",
            ], 422);
        }

        DB::transaction(function () use ($option) {
            $option->items()->delete();
            $option->delete();
        });

        return response()->json([
            'success' => true,
            'message' => 'Option berhasil dihapus.',
        ]);
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'title'               => ['required', 'string', 'max:255'],
            'description'         => ['required', 'string'],
            'items'               => ['required', 'array', 'min:1'],
            'items.*.id'          => ['nullable', 'uuid'],
            'items.*.description' => ['required', 'string', 'max:255'],
        ]);
    }

    private function syncItems(Option $option, array $items): void
    {
        $keep = [];

        foreach ($items as $row) {
            $item = !empty($row['id'])
                ? $option->items()->whereKey($row['id'])->first()
                : null;

            if ($item) {
                $item->update(['description' => $row['description']]);
            } else {
                $item = $option->items()->create(['description' => $row['description']]);
            }

            $keep[] = $item->id;
        }

        $option->items()->whereNotIn('id', $keep)->delete();
    }
}