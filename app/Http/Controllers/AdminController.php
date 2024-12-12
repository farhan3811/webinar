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
use Illuminate\Support\Facades\Http;
use App\Imports\RegistrationsImport;
use Illuminate\Support\Facades\Session;


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
    
        $path = public_path('sertif/sertif.jpeg');
        if (!file_exists($path)) {
            return redirect()->route('datamahasiswa')->with('error', 'Gambar sertifikat tidak ditemukan.');
        }
        $image = imagecreatefromjpeg($path);
    
        $textColor = imagecolorallocate($image, 7, 97, 167);

        $fontSize = 40;
        $fontPath = public_path('fonts/DejaVuSansCondensed.ttf');
    
        $text = $registration->name;
        $xPosition = (imagesx($image) - strlen($text) * $fontSize) / 1.6;
        $yPosition = 275;
    
        imagettftext($image, $fontSize, 0, $xPosition, $yPosition, $textColor, $fontPath, $text);
    
        $modifiedCertificatePath = storage_path('app/public/modified_certificates/' . $registration->nim . '_certificate.png');
        if (!file_exists(storage_path('app/public/modified_certificates'))) {
            mkdir(storage_path('app/public/modified_certificates'), 0777, true);
        }
    
        imagepng($image, $modifiedCertificatePath);
    
        imagedestroy($image);
    
        $templateEmail = $registration->graduation_type === 'online' ? 'emails.online' : 'emails.onsite';
    
        try {
            Mail::to($registration->email)->send(new RegistrationApproved($registration, $modifiedCertificatePath, $templateEmail));
    
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
    public function update(Request $request, $id)
    {
        $registration = Registration::findOrFail($id);

        $registration->update($request->only([
            'name',
            'email',
            'nim',
            'program_studi',
            'kode_unik',
            'phone',
            'address',
            'province',
            'postal_code',
            'graduation_type',
            'toga-size',
            'pendamping',
            'seat_number',
            'delivery',
            'city'
        ]));

        return response()->json(['success' => true]);
    }

    public function checkIn(Request $request, $nim)
    {
        $registration = Registration::where('nim', $nim)->first();

        if ($registration) {
            if ($registration->status === 'approved' && !$registration->checked_in) {
                $registration->checked_in = true;
                $registration->check_in_date = now()->setTimezone('Asia/Jakarta');
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
                ->orWhere('kode_unik', 'like', '%' . $search . '%')
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

    public function bulkApprove(Request $request)
    {
        $ids = $request->input('ids');
        $registrations = Registration::whereIn('id', $ids)->get();
    
        $modifiedCertificatePath = storage_path('app/public/modified_certificates/');
        if (!file_exists($modifiedCertificatePath)) {
            mkdir($modifiedCertificatePath, 0777, true);
        }
    
        foreach ($registrations as $registration) {
            $registration->status = 'approved';
            $registration->save();
    
            $path = public_path('sertif/sertif.jpeg');
            if (!file_exists($path)) {
                return redirect()->route('datamahasiswa')->with('error', 'Gambar sertifikat tidak ditemukan.');
            }
            $image = imagecreatefromjpeg($path);
            $textColor = imagecolorallocate($image, 7, 97, 167); 
            $fontSize = 40;
            $fontPath = public_path('fonts/DejaVuSansCondensed.ttf');
    
            $text = $registration->name;
            $xPosition = (imagesx($image) - strlen($text) * $fontSize) / 1.6;
            $yPosition = 275; 
    
            imagettftext($image, $fontSize, 0, $xPosition, $yPosition, $textColor, $fontPath, $text);

            $modifiedCertificatePathFile = $modifiedCertificatePath . $registration->nim . '_certificate.png';
            imagepng($image, $modifiedCertificatePathFile);
            imagedestroy($image);

            $templateEmail = $registration->graduation_type === 'online' ? 'emails.online' : 'emails.onsite';
    
 
            try {
                Mail::to($registration->email)->send(new RegistrationApproved($registration, $modifiedCertificatePathFile, $templateEmail));
    

                EmailLog::create([
                    'recipient' => $registration->email,
                    'status' => 'Sukses',
                    'subject' => 'Persetujuan Pendaftaran Wisuda',
                    'error_message' => null,
                ]);
            } catch (\Exception $e) {
                // Log pengiriman email gagal
                EmailLog::create([
                    'recipient' => $registration->email,
                    'status' => 'Gagal',
                    'subject' => 'Persetujuan Pendaftaran Wisuda',
                    'error_message' => $e->getMessage(),
                ]);
                Log::error('Gagal mengirim email ke ' . $registration->email . ': ' . $e->getMessage());
            }
        }
    
        return response()->json(['success' => true]);
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
