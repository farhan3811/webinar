<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Registration;
use Illuminate\Validation\Rule;

class RegistrationController extends Controller
{
    public function showForm()
    {
        return view('registration.form');
    }
    
    public function store(Request $request)
    {
        $allowedNims = config('allowed_nims');

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'email' => 'required|email|max:255',
            'confirm_email' => 'required|same:email',
            'program_studi' => 'required|string|max:255',
            'nim' => [
                'required',
                'string',
                Rule::in($allowedNims),
                'unique:registrations,nim'
            ],
            'graduation_type' => 'required|string|in:online,onsite',
            'toga_size' => 'required|string|in:S,M,L,XL,XXL',
            'delivery' => 'required|string|in:Dikirim,Ambil Dikampus Universitas Siber Asia',
            'graduation_payment_file' => 'required|file|mimes:jpg,png,jpeg|max:10240',
            'family_payment_file' => 'nullable|file|mimes:jpg,png,jpeg|max:10240',
        ]);

        if ($request->delivery === 'Dikirim') {
            $request->validate([
                'address' => 'required|string|max:255',
                'city' => 'required|string|max:255',
                'province' => 'required|string|max:255',
                'postal_code' => 'required|string|max:10',
            ]);
        }

        $registration = new Registration($validated);

        if ($request->hasFile('graduation_payment_file')) {
            $graduationPaymentPath = $request->file('graduation_payment_file')->store('bukti_pembayaran/wisuda');
            $registration->graduation_payment_file = $graduationPaymentPath;
        }
        if ($request->hasFile('family_payment_file')) {
            $familyPaymentPath = $request->file('family_payment_file')->store('bukti_pembayaran/keluarga');
            $registration->family_payment_file = $familyPaymentPath;
        }
        if (!in_array($request->nim, $allowedNims)) {
            return redirect()->back()->withInput()->with('nim_error', 'NIM Anda tidak terdaftar sebagai peserta wisuda.');
        }
        $registration->kode_unik = 'WD' . str_pad(Registration::max('id') + 1, 3, '0', STR_PAD_LEFT);
        
        $registration->save();

        return back()->with('success', 'Pendaftaran berhasil!');
    }

    public function dashboard()
    {
        $totalPendaftar = Registration::count();
        $totalApproved = Registration::where('status', 'approved')->count(); // Approved
        $totalCheckIn = Registration::where('checked_in', true)->count(); // Check-in

        return view('dashboard', [
            'totalPendaftar' => $totalPendaftar,
            'totalApproved' => $totalApproved,
            'totalCheckIn' => $totalCheckIn,
        ]);
    }
}
