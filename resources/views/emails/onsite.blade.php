<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Undangan Wisuda Universitas Siber Asia</title>
</head>

<body>
    <p><a href="https://bit.ly/3Zl8OUN">Undangan Wisudawan</a></p>
    <p><a href="https://bit.ly/3CY0L8Z">Denah Wisuda</a></p>

    <p><strong>Kepada Yth.</strong><br>
        {{ $registration->name }}<br>
        Program Studi {{ $registration->program_studi }}<br>
        di Tempat</p>

    <p>Dengan hormat,</p>

    <p>Dengan penuh rasa syukur dan kebanggaan, kami mengundang Saudara/i untuk menghadiri acara Wisuda Program Sarjana
        (S1) Universitas Siber Asia. Acara ini merupakan puncak dari perjalanan akademik Saudara/i dan tanda penghargaan
        atas usaha dan dedikasi yang telah Saudara/i tunjukkan selama menempuh pendidikan di Universitas Siber Asia.
        Adapun acara wisuda akan dilaksanakan pada:</p>

    <p><strong>Hari, Tanggal:</strong> Minggu, 08 Desember 2024<br>
        <strong>Waktu:</strong> 08:00 s.d 12:30 WIB<br>
        <strong>Tempat:</strong> <em>UNAS AUDITORIUM</em><br>
        <strong>Alamat:</strong> Jl. Sawo Manila No.61, Pejaten, Pasar Minggu, Jakarta Selatan
    </p>

    <p><img src="{{ $message->embed($barcodePath) }}" alt="QR Code"></p>

    <p>Kami berharap kehadiran Saudara/i beserta keluarga dapat memeriahkan acara ini dan menjadikannya momen berharga
        dalam hidup Saudara/i.</p>

    <p>Demikian undangan ini kami sampaikan. Atas perhatian dan kehadiran Anda, kami ucapkan terima kasih.</p>

    <p><strong>Hormat kami,</strong><br>
        Tim Pendaftaran Wisuda<br>
        Universitas Siber Asia</p>

    <p><strong>Kontak Bagian Pendaftaran:</strong><br>
        Fian: (+62) 815-1469-6934<br>
        Holis: (+62) 812-1898-7353</p>

    <p><strong>Silakan simak informasi terkait wisuda onsite berikut ini. Sampai bertemu pada acara Wisuda Universitas
            Siber Asia Periode 2.</strong></p>
    <br>
    <p>Nomor duduk Anda adalah <strong>{{ $registration->seat_number }}</strong><br>
        Kode Unik untuk Keluarga Pendamping adalah<strong>{{ $registration->kode_unik }}</strong><br>
        Mohon pastikan kode unik ini diinformasikan kepada keluarga pendamping untuk kelancaran proses pendaftaran.
    </p>

    <p><a href="https://bit.ly/3ZDSEr2">Tata Tertib Wisudawan/Wati secara Onsite</a><br>
        <a href="https://bit.ly/3OJ9T41">Petunjuk Masuk Acara Wisuda Khusus Wisudawan/Wati secara Onsite</a><br>
        <a href="https://bit.ly/3CY0L8Z">Denah Wisuda</a><br>
        <a href="https://bit.ly/3OJ9T41">Petunjuk Masuk Acara Wisuda Khusus Keluarga Pendamping & Tambahan</a><br>
        <a href="https://bit.ly/49s3HqK">Rekomendasi Akomodasi Penginapan</a>
    </p>

    <p><strong>Imbauan:</strong><br>
        - Selama acara wisuda berlangsung, Calon Wisudawan/Wati tidak diperkenankan makan hingga acara selesai. Kami
        menyarankan agar Calon Wisudawan/Wati sarapan terlebih dahulu di pagi hari. Untuk snack dapat dititipkan kepada
        keluarga yang mendampingi.<br>
        - Bagi Keluarga Pendamping & Tambahan selama acara wisuda berlangsung, dimohon untuk menjaga ketertiban dan
        ketenangan hingga acara selesai.<br>
        - Harap membuang sampah pada tempat yang telah disediakan untuk menjaga kebersihan lokasi acara Wisuda.</p>

    <p><a href="https://bit.ly/41llBcy">FAQ Wisuda UNSIA</a></p>
</body>

</html>