<?php

namespace App\Http\Controllers;

use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RegistrationsExport;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegistrationApproved;
use App\Models\Registration;
use App\Models\EmailLog;
use Illuminate\Support\Facades\Log;


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
        $registration = Registration::findOrFail($id);
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

        try {
            Mail::to($registration->email)->send(new RegistrationApproved($registration, $tempFilePath));
            EmailLog::create([
                'recipient' => $registration->email,
                'status' => 'Sukses',
                'subject' => 'Persetujuan Pendaftaran Wisuda',
                'error_message' => null,
            ]);
        } catch (\Exception $e) {
            EmailLog::create([
                'recipient' => $registration->email,
                'status' => 'Gagal',
                'subject' => 'Persetujuan Pendaftaran Wisuda',
                'error_message' => $e->getMessage(),
            ]);
            Log::error('Gagal mengirim email ke ' . $registration->email . ': ' . $e->getMessage());
        }

        return redirect()->route('datamahasiswa')->with('success', 'Pendaftaran berhasil diapprove.');
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
                $registration->check_in_date = now();
                $registration->save();

                return response()->json(['success' => true, 'message' => 'Check-in berhasil!']);
            }
        }

        return response()->json(['success' => false, 'message' => 'Check-in gagal!'], 400);
    }
    public function dataCheckIn(Request $request)
    {
        $search = $request->get('search'); 
    
        $checkIns = Registration::query()
            ->where('checked_in', true)
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('nim', 'like', '%' . $search . '%')
                    ->orWhere('kode_unik', 'like', '%' . $search . '%');
            })
            ->orderBy('check_in_date', 'desc')
            ->paginate(10);
    
        return view('admin.data-checkin', compact('checkIns'));
    }
    
    public function dataMahasiswa(Request $request)
    {
        $search = $request->get('search');

        $registrations = Registration::when($search, function ($query, $search) {
            return $query->where('name', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%')
                ->orWhere('nim', 'like', '%' . $search . '%');
        })
            ->paginate(10);

        return view('admin.datamahasiswa', compact('registrations'));
    }
    public function emailLogs()
    {
        $logs = EmailLog::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.email-logs', compact('logs'));
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
