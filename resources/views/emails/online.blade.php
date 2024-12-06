<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Undangan Wisuda</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; margin: 20px; color: #333;">
    <p>Kepada Yth.<br>
    <strong>{{ $registration->name }}</strong><br>
    Program Studi {{ $registration->program_studi }}<br>
    di Tempat</p>

    <p>Dengan hormat,</p>

    <p>Dengan penuh rasa syukur dan kebanggaan, kami mengundang Saudara/i untuk menghadiri acara Wisuda Program Sarjana (S1) Universitas Siber Asia. Acara ini merupakan puncak dari perjalanan akademik Saudara/i dan tanda penghargaan atas usaha dan dedikasi yang telah Saudara/i tunjukkan selama menempuh pendidikan di Universitas Siber Asia. Adapun acara wisuda akan dilaksanakan pada:</p>

    <p><strong>Hari, Tanggal:</strong> Minggu, 08 Desember 2024<br>
    <strong>Waktu:</strong> 08:00 s.d 12:30 WIB<br>
    <strong>Tempat:</strong> ONLINE (ZOOM)<br>
    <strong>Link Zoom:</strong> <a href="https://bit.ly/WisudaUnsia2" target="_blank">https://bit.ly/WisudaUnsia2</a><br>
    <strong>Meeting ID:</strong> 975 0128 8579</p>
    <p><strong>Virtual Background Zoom:</strong> <a href="https://bit.ly/BGZoomWisudaUnsia2" target="_blank">https://bit.ly/BGZoomWisudaUnsia2</a><br>
    <strong>Live Streaming YouTube:</strong> <a href="https://youtube.com/live/dr01Tjfc14Q?feature=share" target="_blank">https://youtube.com/live/dr01Tjfc14Q?feature=share</a></p>

    <p>Kami berharap kehadiran Saudara/i dapat memeriahkan acara ini dan menjadikannya momen berharga dalam hidup Saudara/i.</p>

    <p>Demikian undangan ini kami sampaikan. Atas perhatian dan kehadiran Anda, kami ucapkan terima kasih.</p>
   <br>
    <p>Link Scan QR Code Absensi Wisuda: <a href="https://bit.ly/3VmvEui">https://bit.ly/3VmvEui</a></p>
    <img src="{{ $message->embed($barcodePath) }}" alt="QR Code">
    <p><strong>Hormat kami,</strong><br>
    Tim Pendaftaran Wisuda<br>
    Universitas Siber Asia</p>

    <p><strong>Kontak Bagian Pendaftaran:</strong><br>
    Fian: (+62) 815-1469-6934<br>
    Holis: (+62) 812-1898-7353</p>

    <p><stong>Silakan simak informasi terkait wisuda online berikut ini. Sampai bertemu pada acara Wisuda Universitas Siber Asia Periode 2</stong></p>
<br>
    <p><a href="https://bit.ly/3ZDSEr2" target="_blank">Tata Tertib Wisudawan/Wati secara Online</a><br>
    <a href="https://bit.ly/3OJ9T41" target="_blank">Petunjuk Masuk Acara Wisuda Khusus Wisudawan/Wati secara Online</a><br>
    <a href="https://bit.ly/41llBcy" target="_blank">FAQ Wisuda UNSIA</a></p>
</body>
</html>
