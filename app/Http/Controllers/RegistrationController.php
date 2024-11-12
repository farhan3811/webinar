<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Registration;

class RegistrationController extends Controller
{
    public function showForm()
    {
        return view('registration.form');
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'email' => 'required|email|max:255',
            'program_studi' => 'required|string|max:255',
'nim' => 'required|string|in:12345,67890,11223|unique:registrations,nim',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'postal_code' => 'required|string|max:10',
            'graduation_type' => 'required|string|in:online,onsite',
            'number_of_guests' => 'nullable|integer|min:0',
            'toga_size' => 'required|string|in:S,M,L,XL,XXL',
            'file' => 'required|file|mimes:jpg,png,pdf|max:10240',
        ]);
        $registration = new Registration($validated);
if ($request->hasFile('file')) {
    $filePath = $request->file('file')->store('bukti_pembayaran');
    $registration->file_path = $filePath;
}
    $existingRegistration = Registration::where('nim', $request->nim)->first();
    if ($existingRegistration) {
        return back()->with('error', 'NIM sudah terdaftar.');
    }
        $registration->save();

        return back()->with('success', 'Pendaftaran berhasil!');
    }
}