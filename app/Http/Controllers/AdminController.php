<?php

namespace App\Http\Controllers;

use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RegistrationsExport;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegistrationApproved;
use App\Models\Registration;


class AdminController extends Controller
{
    public function index()
    {
        $registrations = Registration::all();
        return view('admin.index', compact('registrations'));
    }
    public function exportExcel(Request $request)
    {
        return Excel::download(new RegistrationsExport, 'registrations.xlsx');
    }
    public function approve($id)
    {
        $registration = Registration::find($id);
        $registration->status = 'approved';
        $registration->save();
    
        $qrData = [
            'nim' => $registration->nim,
            'name' => $registration->name,
            'email' => $registration->email,
        ];
    
        $qrString = json_encode($qrData);

        $tempFilePath = storage_path('app/public/qr_codes/' . $registration->nim . '.png');
        QrCode::format('png')->size(400)->generate($qrString, $tempFilePath);
        Mail::to($registration->email)->send(new RegistrationApproved($registration, $tempFilePath));
        return redirect()->route('datamahasiswa');
    }
    public function scanQr()
{
    return view('admin.scan');
}
public function checkIn(Request $request, $nim)
{
    $registration = Registration::where('nim', $nim)->first();

    if ($registration) {
        if ($registration->status === 'approved' && !$registration->checked_in) {
            $registration->checked_in = true; 
            $registration->save();
            
            return response()->json(['success' => true]);
        }
    }

    return response()->json(['success' => false], 400);
}
    public function dataMahasiswa(Request $request)
    {
        $search = $request->get('search');

        $registrations = Registration::when($search, function($query, $search) {
            return $query->where('name', 'like', '%' . $search . '%')
                         ->orWhere('email', 'like', '%' . $search . '%')
                         ->orWhere('nim', 'like', '%' . $search . '%');
        })
        ->paginate(10);

        return view('admin.datamahasiswa', compact('registrations'));
    }

    public function updateStatus(Request $request, $id)
    {
        $registration = Registration::findOrFail($id);
        $registration->status = $request->status;
        $registration->save();
        return redirect()->route('datamahasiswa')->with('success', 'Status berhasil diperbarui');
    }
    public function showDetails($id)
{
    $registration = Registration::findOrFail($id);
    return view('admin.details', compact('registration'));
}
}
