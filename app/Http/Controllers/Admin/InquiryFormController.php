<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InquiryForm;
use Illuminate\Http\Request;

class InquiryFormController extends Controller
{
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
     * Get all inquiries.
     */
    public function getData(Request $request)
    {
        $fullname = $request->query('fullname');
        $companyName = $request->query('company_name');
        $country = $request->query('country');
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        $perPage = min(
            (int) $request->query('per_page', 10),
            100
        );

        $data = InquiryForm::query()
            ->when($fullname, function ($query, $fullname) {
                $query->where('fullname', 'like', '%' . $fullname . '%');
            })
            ->when($companyName, function ($query, $companyName) {
                $query->where('company_name', 'like', '%' . $companyName . '%');
            })
            ->when($country, function ($query, $country) {
                $query->where('country', 'like', '%' . $country . '%');
            })
            ->when($startDate, function ($query, $startDate) {
                $query->whereDate('created_at', '>=', $startDate);
            })
            ->when($endDate, function ($query, $endDate) {
                $query->whereDate('created_at', '<=', $endDate);
            })
            ->latest('created_at')
            ->paginate($perPage);

        return response()->json($data);
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