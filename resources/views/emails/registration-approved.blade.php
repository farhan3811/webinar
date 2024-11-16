<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Undangan Wisuda</title>
</head>
<body>
    <h1>Selamat atas Kelulusan Anda!</h1>
    <p>Yth. {{ $registration->name }},</p>
    <p>Dengan bangga, kami mengundang Anda untuk menghadiri acara wisuda sebagai bentuk apresiasi atas pencapaian akademik Anda.</p>
    <p>Nomor Induk Mahasiswa : {{ $registration->nim }}</p>
    <p>Nomor Handphone : {{ $registration->phone }}</p>
    <p>Program Studi : {{ $registration->program_studi }}</p>
    <p>Harap tunjukkan QR code berikut saat kedatangan:</p>
    <p>Jenis Kehadiran: {{ $registration->graduation_type }}</p>
    <img src="{{ $message->embed($barcodePath) }}" alt="QR Code">
    @if($registration->graduation_type == 'online')
        <p>Karena Anda memilih untuk hadir secara online, harap klik link berikut untuk melakukan scan QR code saat acara:</p>
        <p><a href="{{ route('admin.scanQr') }}">Scan QR Code untuk Kehadiran Online</a></p>
    @else
        <p></p>
    @endif

    <p>Terima kasih atas partisipasi Anda. Sampai jumpa di acara wisuda!</p>
</body>
</html>
