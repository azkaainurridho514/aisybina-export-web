<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InquiryForm;
use Illuminate\Http\Request;

class InquiryFormController extends Controller
{
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