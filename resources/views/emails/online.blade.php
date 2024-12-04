<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Persetujuan Pendaftaran Wisuda</title>
</head>

<body>
    <p class="font-weight: bold;">Kepada Yth. {{ $registration->name }},</p>
    <p>Program Studi {{ $registration->program_studi }}</p>
    <br>
    <p>Dengan penuh rasa syukur dan kebanggaan, kami mengundang Saudara/i untuk menghadiri acara Wisuda Program Sarjana
        (S1) Universitas Siber Asia. Acara ini merupakan puncak dari perjalanan akademik Saudara/i dan tanda penghargaan
        atas usaha dan dedikasi yang telah Saudara/i tunjukkan selama menempuh pendidikan di Universitas Siber Asia.
        Adapun acara wisuda akan dilaksanakan pada:</p>
    <p>Hari, Tanggal: Minggu, 08 Desember 2024</p>
    <p>Waktu: 08:00 s.d 12:30 WIB</p>
    <p>Tempat: ONLINE (ZOOM)</p>
    <p>Link Zoom: <a href="https://bit.ly/WisudaUnsia2">https://bit.ly/WisudaUnsia2</a> </p>
    <p>Meeting ID: 975 0128 8579</p>
    <p>Virtual Background Zoom: <a href="https://bit.ly/BGZoomWisudaUnsia2">https://bit.ly/BGZoomWisudaUnsia2</a> </p>
    <p>Live Streaming YouTube: <a href="https://youtube.com/live/dr01Tjfc14Q?feature=share">https://youtube.com/live/dr01Tjfc14Q?feature=share</a></p>
    <p>Kami berharap kehadiran Saudara/i dapat memeriahkan acara ini dan menjadikannya momen berharga dalam hidup Saudara/i.</p>
    <p>Demikian undangan ini kami sampaikan. Atas perhatian dan kehadiran Anda, kami ucapkan terima kasih.</p>
    <br>
    <p>Link Scan QR Code Absensi Wisuda: <a href="https://bit.ly/3VmvEui">https://bit.ly/3VmvEui</a></p>
    <img src="{{ $message->embed($barcodePath) }}" alt="QR Code">
<br>
    <p>Hormat kami,</p>
    <p>Tim Pendaftaran Wisuda</p>
    <p>Universitas Siber Asia</p>
    <br>
    <p>Kontak Bagian Pendaftaran:</p>
    <p>Fian: (+62) 815-1469-6934</p>
    <p>Holis: (+62) 812-1898-7353</p>
</body>

</html>