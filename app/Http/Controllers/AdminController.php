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
            'kode_unik' => $registration->kode_unik,
            'nim' => $registration->nim,
            'name' => $registration->name,
            'email' => $registration->email,
        ];

        $qrString = json_encode($qrData);
        $tempPngFilePath = storage_path('app/public/qr_codes/' . $registration->nim . '.png');

        QrCode::format('png')->margin(5)->backgroundColor(255, 255, 255)->size(400)->generate($qrString, $tempPngFilePath);

        $tempJpgFilePath = str_replace('.png', '.jpg', $tempPngFilePath);
        $image = imagecreatefrompng($tempPngFilePath);
        imagejpeg($image, $tempJpgFilePath);
        imagedestroy($image);
        $templateWhatsApp = $registration->graduation_type === 'online' ?
            'whatsapp.online' : 'whatsapp.onsite';

        $templateEmail = $registration->graduation_type === 'online' ? 'emails.online' : 'emails.onsite';


        $message = view($templateWhatsApp, [
            'name' => $registration->name,
            'nim' => $registration->nim,
            'phone' => $registration->phone,
            'program_studi' => $registration->program_studi,
            'graduation_type' => $registration->graduation_type,
            'seat_number' => $registration->seat_number,
            'kode_unik' => $registration->kode_unik,
            
        ])->render();

        try {
            Mail::to($registration->email)->send(new RegistrationApproved($registration, $tempJpgFilePath, $templateEmail));
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
        // Kirim WhatsApp
        try {
            Http::withHeaders([
                'Authorization' => 'zYrwBIfakpqS2Vm5dL2wbiknSDiXMQqbpiCdljaQHZ0itwGxsB3qCRRQnHcmMebf',
            ])->attach('image', file_get_contents($tempJpgFilePath), 'QR_Code.jpg')
                ->post('https://jkt.wablas.com/api/send-image', [
                    'phone' => $registration->phone,
                    'caption' => $message,
                ]);
        } catch (\Exception $e) {
            Log::error('Error WhatsApp: ' . $e->getMessage());
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
    
        foreach ($registrations as $registration) {
            // Update status pendaftaran
            $registration->status = 'approved';
            $registration->save();
    
            // Generate QR Code
            $qrData = [
                'nim' => $registration->nim,
                'name' => $registration->name,
                'email' => $registration->email,
            ];
            $qrString = json_encode($qrData);
            $tempPngFilePath = storage_path('app/public/qr_codes/' . $registration->nim . '.png'); // Simpan sebagai PNG
    
            // Generate QR Code dengan border putih
            QrCode::format('png')
                ->size(400)
                ->color(0, 0, 0) // QR code hitam
                ->backgroundColor(255, 255, 255) // Latar belakang putih
                ->margin(10) // Margin putih di sekitar QR code
                ->generate($qrString, $tempPngFilePath);
    
            // Convert PNG ke JPG (jika perlu)
            $tempJpgFilePath = storage_path('app/public/qr_codes/' . $registration->nim . '.jpg'); // File JPG akhir
            $image = imagecreatefrompng($tempPngFilePath); // Load PNG
            imagejpeg($image, $tempJpgFilePath); // Convert ke JPG
            imagedestroy($image); // Hapus gambar untuk menghemat memori
    
            // Menentukan template email dan WhatsApp berdasarkan jenis wisuda
            $templateWhatsApp = $registration->graduation_type === 'online' ? 'whatsapp.online' : 'whatsapp.onsite';
            $templateEmail = $registration->graduation_type === 'online' ? 'emails.online' : 'emails.onsite';
    
            // Kirim Email
            try {
                Mail::to($registration->email)->send(new RegistrationApproved($registration, $tempJpgFilePath, $templateEmail));
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
            try {
                $message = view($templateWhatsApp, [
                    'name' => $registration->name,
                    'nim' => $registration->nim,
                    'phone' => $registration->phone,
                    'program_studi' => $registration->program_studi,
                    'graduation_type' => $registration->graduation_type,
                    'seat_number' => $registration->seat_number,
                    'kode_unik' => $registration->kode_unik,
                ])->render();
    
                $response = Http::withHeaders([
                    'Authorization' => 'zYrwBIfakpqS2Vm5dL2wbiknSDiXMQqbpiCdljaQHZ0itwGxsB3qCRRQnHcmMebf',
                ])->attach('image', file_get_contents($tempJpgFilePath), 'QR_Code.jpg')
                    ->post('https://jkt.wablas.com/api/send-image', [
                        'phone' => $registration->phone,
                        'caption' => $message,
                        'image' => 'https://pendaftaranwisuda.unsia.ac.id/denahwisuda.png',
                    ]);
    
                if ($response->successful()) {
                    Log::info('Pesan WhatsApp berhasil dikirim ke ' . $registration->phone);
                } else {
                    Log::error('Gagal mengirim WhatsApp: ' . $response->body());
                }
            } catch (\Exception $e) {
                Log::error('Error saat mengirim WhatsApp: ' . $e->getMessage());
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
