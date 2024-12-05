<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Undangan Wisuda</title>
</head>
<body>
    <p><strong>Desain Undangan Wisudawan/Wati – Terlampir</strong></p>
    <p><strong>Denah Pendaftaran Wisuda</strong></p>
    <p><strong>Copies Undangan Wisuda Onsite</strong></p>

    <p><strong>Kepada Yth.</strong><br>
    {{ $registration->name }}<br>
    Program Studi {{ $registration->program_studi }}<br>
    di Tempat</p>

    <p>Dengan hormat,</p>

    <p>Dengan penuh rasa syukur dan kebanggaan, kami mengundang Saudara/i untuk menghadiri acara Wisuda Program Sarjana (S1) Universitas Siber Asia. Acara ini merupakan puncak dari perjalanan akademik Saudara/i dan tanda penghargaan atas usaha dan dedikasi yang telah Saudara/i tunjukkan selama menempuh pendidikan di Universitas Siber Asia. Adapun acara wisuda akan dilaksanakan pada:</p>

    <p><strong>Hari, Tanggal:</strong> Minggu, 08 Desember 2024<br>
    <strong>Waktu:</strong> 08:00 s.d 12:30 WIB<br>
    <strong>Tempat:</strong> <strong>UNAS AUDITORIUM</strong><br>
    <strong>Alamat:</strong> Jl. Sawo Manila No.61, Pejaten, Pasar Minggu, Jakarta Selatan</p>

    <p>Kami berharap kehadiran Saudara/i beserta keluarga dapat memeriahkan acara ini dan menjadikannya momen berharga dalam hidup Saudara/i.</p>

    <p>Demikian undangan ini kami sampaikan. Atas perhatian dan kehadiran Anda, kami ucapkan terima kasih.</p>

    <p><strong>Hormat kami,</strong><br>
    Tim Pendaftaran Wisuda<br>
    Universitas Siber Asia</p>

    <p><strong>Kontak Bagian Pendaftaran:</strong><br>
    Fian: (+62) 815-1469-6934<br>
    Holis: (+62) 812-1898-7353</p>

    <p><img src="{{ $message->embed($barcodePath) }}" alt="QR Code"></p>

    <p><strong>Nomor duduk Anda adalah {{ $registration->seat_number }}</strong></p>
    <p><strong>Kode Unik untuk Keluarga Pendamping adalah {{ $registration->kode_unik }}</strong><br>
    Mohon pastikan kode unik ini diinformasikan kepada keluarga pendamping untuk kelancaran proses pendaftaran.</p>
    <p><strong>Scan Barcode Wisudawan/Wati – Terlampir</strong></p>
    <p><strong>Tata Tertib Wisudawan/Wati secara Onsite >> <a href="https://bit.ly/3ZDSEr2">Tata Tertib</a></strong></p>
    <p><strong>Petunjuk Masuk Acara Wisuda Khusus Wisudawan/Wati secara Onsite >> <a href="https://bit.ly/3OJ9T41">Petunjuk Masuk</a></strong></p>
</body>
</html>
