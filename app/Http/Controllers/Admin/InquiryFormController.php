<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\PaginatesAdminList;
use App\Http\Controllers\Controller;
use App\Models\InquiryForm;
use Illuminate\Http\Request;

class InquiryFormController extends Controller
{
    use PaginatesAdminList;

    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name'         => 'required|string|max:255',
            'company_name'      => 'nullable|string|max:255',
            'email'             => 'required|email|max:255',
            'phone'             => 'nullable|string|max:50',
            'country'           => 'nullable|string|max:255',
            'product_interest'  => 'nullable|string|max:255',
            'quantity'          => 'nullable|string|max:255',
            'message'           => 'required|string',
        ]);

        $inquiry = InquiryForm::create([
            'fullname'            => $validated['full_name'],
            'company_name'        => $validated['company_name'] ?? '',
            'email'               => $validated['email'],
            'whatsapp'            => $validated['phone'] ?? '',
            'country'             => $validated['country'] ?? '',
            'product_interested'  => $validated['product_interest'] ?? '',
            'estimated_quantity'  => $validated['quantity'] ?? '',
            'message'             => $validated['message'],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Your inquiry has been successfully submitted. We will contact you shortly.',
            'data'    => $inquiry,
        ]);
    }

    /**
     * Halaman daftar inquiry (Blade, dirender server) dengan filter.
     */
    public function index(Request $request)
    {
        $filters = $request->only(['fullname', 'company_name', 'country', 'start_date', 'end_date']);

        $inquiries = $this->filteredQuery($filters)
            ->latest('created_at')
            ->paginate(10)
            ->withQueryString();

        if ($redirect = $this->lastPageRedirect($inquiries, 'admin.inquiries.index', $filters)) {
            return $redirect;
        }

        return view('admin.inquiries.index', [
            'inquiries' => $inquiries,
            'filters'   => $filters,
        ]);
    }

    /**
     * Data untuk export Excel (JSON; file .xlsx dibuat di browser).
     * Batas 5000 baris agar respons tetap ringan.
     */
    public function export(Request $request)
    {
        $rows = $this->filteredQuery($request->only(['start_date', 'end_date']))
            ->latest('created_at')
            ->limit(5000)
            ->get()
            ->map(fn ($r) => [
                'Tanggal'         => optional($r->created_at)->format('Y-m-d H:i:s'),
                'Nama'            => $r->fullname,
                'Perusahaan'      => $r->company_name,
                'Email'           => $r->email,
                'WhatsApp'        => $r->whatsapp,
                'Negara'          => $r->country,
                'Produk Diminati' => $r->product_interested,
                'Estimasi Qty'    => $r->estimated_quantity,
                'Pesan'           => $r->message,
            ]);

        return response()->json(['data' => $rows]);
    }

    /**
     * Query dengan filter yang dipakai daftar dan export.
     */
    private function filteredQuery(array $filters)
    {
        $like = fn ($value) => '%' . addcslashes((string) $value, '%_\\') . '%';

        return InquiryForm::query()
            ->when($filters['fullname'] ?? null, fn ($q, $v) => $q->where('fullname', 'like', $like($v)))
            ->when($filters['company_name'] ?? null, fn ($q, $v) => $q->where('company_name', 'like', $like($v)))
            ->when($filters['country'] ?? null, fn ($q, $v) => $q->where('country', 'like', $like($v)))
            ->when($filters['start_date'] ?? null, fn ($q, $v) => $q->whereDate('created_at', '>=', $v))
            ->when($filters['end_date'] ?? null, fn ($q, $v) => $q->whereDate('created_at', '<=', $v));
    }

    /**
     * Get one inquiry.
     */
    public function show(string $id)
    {
        $inquiry = InquiryForm::find($id);

        if (!$inquiry) {
            return response()->json([
                'message' => 'Data tidak ditemukan.'
            ], 404);
        }

        return response()->json($inquiry);
    }

    /**
     * Delete inquiry.
     */
    public function destroy(string $id)
    {
        $inquiry = InquiryForm::find($id);

        if (!$inquiry) {
            return response()->json([
                'message' => 'Data tidak ditemukan.'
            ], 404);
        }

        $inquiry->delete();

        return response()->json([
            'message' => 'Inquiry berhasil dihapus.',
            'id' => $id,
        ]);
    }
}