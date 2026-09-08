<?php

namespace App\Http\Controllers;

use App\Models\BusinessHour;
use App\Models\InquiryForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ContactController extends Controller
{
    /**
     * Get contact information.
     */
    public function getData()
    {
        $contact = DB::table('contact')->first();

        if (!$contact) {
            return response()->json([
                'message' => 'Data contact tidak ditemukan.'
            ], 404);
        }

        return response()->json([
            'contact' => $contact,
            'business_hours' => BusinessHour::latest()->get(),
        ]);
    }

    /**
     * Submit inquiry form.
     */
    public function submitInquiry(Request $request)
    {
        $data = $request->validate([
            'fullname' => 'required|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'email' => 'required|email|max:255',
            'whatsapp' => 'required|string|max:50',
            'country' => 'required|string|max:100',
            'product_interested' => 'required|string|max:255',
            'estimated_quantity' => 'nullable|string|max:255',
            'message' => 'required|string',
        ]);

        $inquiry = InquiryForm::create([
            'id' => (string) Str::uuid(),
            'fullname' => $data['fullname'],
            'company_name' => $data['company_name'] ?? null,
            'email' => $data['email'],
            'whatsapp' => $data['whatsapp'],
            'country' => $data['country'],
            'product_interested' => $data['product_interested'],
            'estimated_quantity' => $data['estimated_quantity'] ?? null,
            'message' => $data['message'],
        ]);

        return response()->json([
            'message' => 'Inquiry berhasil dikirim.',
            'data' => $inquiry,
        ], 201);
    }
}