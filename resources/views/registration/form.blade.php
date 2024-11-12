<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pendaftaran Wisuda</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <form action="{{ route('registration.store') }}" method="POST" enctype="multipart/form-data"
        class="bg-white p-6 rounded-lg shadow-md w-full max-w-md my-4">
        @csrf
        <h2 class="text-2xl font-bold text-center text-gray-700 mb-6">Form Pendaftaran Wisuda</h2>

        <div class="mb-4">
            <label class="block text-gray-600 font-semibold">Nama</label>
            <input type="text" name="name" required
                class="w-full mt-2 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>

        <div class="mb-4">
            <label class="block text-gray-600 font-semibold">No Handphone Aktif</label>
            <input type="text" name="phone" required
                class="w-full mt-2 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>

        <div class="mb-4">
            <label class="block text-gray-600 font-semibold">Email Aktif</label>
            <input type="email" name="email" id="email" required
                class="w-full mt-2 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>

        <div class="mb-4">
            <label class="block text-gray-600 font-semibold">Konfirmasi Email</label>
            <input type="email" name="confirm_email" id="confirm_email" required
                class="w-full mt-2 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>

        <div class="mb-4">
            <label class="block text-gray-600 font-semibold">Program Studi</label>
            <select name="program_studi" required
                class="w-full mt-2 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                <option value="">-- Pilih Program Studi --</option>
                <option value="Informatika">Informatika</option>
                <option value="Sistem Informasi">Sistem Informasi</option>
                <option value="Komunikasi">Komunikasi</option>
                <option value="Akuntansi">Akuntansi</option>
                <option value="Manajemen">Manajemen</option>
            </select>
        </div>

        <div class="mb-4">
            <label class="block text-gray-600 font-semibold">Nomor Induk Mahasiswa</label>
            <input type="text" name="nim" required
                class="w-full mt-2 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>

        <div class="mb-4">
            <label class="block text-gray-600 font-semibold">Saya Mengikuti Wisuda Secara</label>
            <div class="flex items-center mt-2 space-x-4">
                <label class="flex items-center">
                    <input type="radio" name="graduation_type" value="online" required class="mr-2"> Online
                </label>
                <label class="flex items-center">
                    <input type="radio" name="graduation_type" value="onsite" required class="mr-2"> Onsite
                </label>
            </div>
        </div>

        <div class="mb-4">
            <img src="{{ url('/gambar/ukuran.jpeg') }}" alt="Gambar Toga"
                class="w-90 h-auto mx-auto mb-4">
            <label class="block text-gray-600 font-semibold">Ukuran Toga</label>
            <select name="toga_size" required
                class="w-full mt-2 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                <option value="">-- Pilih Ukuran Toga --</option>
                <option value="S">S</option>
                <option value="M">M</option>
                <option value="L">L</option>
                <option value="XL">XL</option>
                <option value="XXL">XXL</option>
            </select>
        </div>
        <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center hidden">
            <img src="{{ url('/gambar/pembayaran.jpeg') }}" alt="Gambar Toga Zoomed" class="max-w-full max-h-full">
            <button onclick="closeModal()" class="absolute top-4 right-4 text-white text-2xl font-bold">&times;</button>
        </div>

        <div class="mb-4">
    <label class="block text-gray-600 font-semibold">Pengiriman</label>
    <select name="delivery" id="delivery" required
        class="w-full mt-2 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
        <option value="">-- Pilih Pengiriman --</option>
        <option value="Dikirim">Dikirim</option>
        <option value="Ambil Dikampus Universitas Siber Asia">Ambil di Kampus Universitas Siber Asia</option>
    </select>
</div>

<div id="campusNote" class="hidden mt-4 text-sm text-gray-600 bg-red-100 p-4 border-l-4 border-red-500">
**Note: Berlaku bagi anda yang melakukan pendaftaran sebelum Sabtu, 23 Nov 2024. Lewat dari tanggal tersebut, silakan ambil di Kampus (Hubungi Tim pendaftaran untuk jadwal pengambilan).
</div>

        <div id="addressFields" class="hidden">
            <div class="mb-4">
                <label class="block text-gray-600 font-semibold">Alamat Lengkap</label>
                <textarea name="address"
                    class="w-full mt-2 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                    rows="3"></textarea>
            </div>

            <div class="mb-4">
                <label class="block text-gray-600 font-semibold">Kota/Kabupaten</label>
                <input type="text" name="city"
                    class="w-full mt-2 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <div class="mb-4">
                <label class="block text-gray-600 font-semibold">Provinsi</label>
                <input type="text" name="province"
                    class="w-full mt-2 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <div class="mb-4">
                <label class="block text-gray-600 font-semibold">Kode Pos</label>
                <input type="text" name="postal_code"
                    class="w-full mt-2 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
        </div>
        <div class="mt-2 mb-2">
    <span class="text-xs text-blue-500 cursor-pointer" onclick="openModal()">
        Klik di sini untuk melihat contoh screenshot pembayaran.
    </span>
</div>

<div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center hidden">
    <img src="{{ url('/gambar/ukuran.jpeg') }}" alt="Contoh Gambar Toga" class="max-w-full max-h-full">
    <button onclick="closeModal()" class="absolute top-4 right-4 text-white text-2xl font-bold">&times;</button>
</div>
        <div class="mb-4">
            <label class="block text-gray-600 font-semibold">Bukti Pembayaran Wisuda</label>
            <input type="file" name="graduation_payment_file" required
                class="w-full mt-2 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>
        <div class="mb-4">
            <label class="block text-gray-600 font-semibold">Bukti Pembayaran Tambah Keluarga Pendamping</label>
            <input type="file" name="family_payment_file"
                class="w-full mt-2 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                <span class="text-xs text-gray">
        File yang didukung jpg,png,jpeg maks 2mb
    </span>
        </div>
        <div class="mb-4 flex items-center">
        <input type="checkbox" id="agreement" name="agreement" required
            class="mr-2 text-blue-500 border-gray-300 focus:ring-blue-500 focus:ring-2">
        <label for="agreement" class="text-sm text-gray-700">
        "Dengan ini saya menyatakan bahwa data yang telah saya isi di atas adalah benar dan akurat sesuai dengan kondisi sebenarnya. Apabila di kemudian hari ditemukan ketidaksesuaian atau kesalahan pengisian, saya bersedia menerima konsekuensi yang ditetapkan".
        </label>
    </div>
        <button type="submit"
            class="w-full bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 transition duration-200">
            Submit
        </button>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    document.getElementById('delivery').addEventListener('change', function () {
        let addressFields = document.getElementById('addressFields');
        if (this.value === 'Dikirim') {
            addressFields.classList.remove('hidden');
        } else {
            addressFields.classList.add('hidden');
        }
    });

    function openModal() {
        document.getElementById('imageModal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('imageModal').classList.add('hidden');
    }

    document.getElementById('imageModal').addEventListener('click', function (e) {
        if (e.target === this) {
            closeModal();
        }
    });

    document.getElementById('delivery').addEventListener('change', function () {
        var campusNote = document.getElementById('campusNote');
        if (this.value === 'Ambil Dikampus Universitas Siber Asia') {
            campusNote.classList.remove('hidden');
        } else {
            campusNote.classList.add('hidden');
        }
    });

    document.querySelector('form').addEventListener('submit', function (event) {
        let nim = document.querySelector('input[name="nim"]').value;
        let email = document.getElementById('email').value;
        let confirmEmail = document.getElementById('confirm_email').value;
        let paymentFile = document.querySelector('input[name="graduation_payment_file"]').files[0];

        let validNIMs = [    
    "200201010200",
    "200201072086",
    "200201072025",
    "200201072106",
    "200201010193",
    "200201072064",
    "200201072281",
    "200201072229",
    "200201072269",
    "200201010179",
    "200201072218",
    "220201020022",
    "200201072150",
    "200201072213",
    "200201072050",
    "200201072298",
    "200201072157",
    "230201020038",
    "200201010077",
    "220201020031",
    "200201010071",
    "200201072104",
    "200201072130",
    "200201072274",
    "200201072197",
    "200201010082",
    "200201072225",
    "200201072123",
    "230201020015",
    "200201072005",
    "200201010172",
    "200201010096",
    "200201072033",
    "220201020040",
    "200201010174",
    "200201010128",
    "200201072051",
    "220201020039",
    "200201072199",
    "200201072011",
    "200201072190",
    "200201072047",
    "200201072297",
    "200201072231",
    "200201010080",
    "200201072173",
    "200201072023",
    "200201010114",
    "200201072167",
    "200201072019",
    "200201072223",
    "200201072095",
    "230201020026",
    "200201072260",
    "200201072162",
    "200201072134",
    "200201072252",
    "230201020017",
    "200201010215",
    "200201072284",
    "200201010118",
    "200201072055",
    "200201072044",
    "200201010074",
    "230201020032",
    "200201072105",
    "200201010178",
    "200201070072",
    "200201010206",
    "200201072112",
    "200201072114",
    "200201010217",
    "200201010151",
    "200201072137",
    "200201072074",
    "200201072002",
    "230201020033",
    "200201010123",
    "200201072276",
    "200201072107",
    "230201020019",
    "230301020003",
    "200301072073",
    "200301072114",
    "200301072062",
    "200301072051",
    "200301072089",
    "200301010034",
    "200301010021",
    "230301020004",
    "200301072066",
    "200301072063",
    "200301010060",
    "200301072064",
    "230301020007",
    "200301072043",
    "220301020007",
    "200301072093",
    "220301020015",
    "200301072061",
    "200501010022",
    "200501010051",
    "200501072010",
    "200501010028",
    "200501010033",
    "200501010009",
    "200501010048",
    "200501010039",
    "200501010105",
    "200501072003",
    "200502072045",
    "220501020011",
    "200501072060",
    "200501010048",
    "200501072057",
    "220101020005",
    "220101020044",
    "230101020071",
    "230101020017",
    "220101020007",
    "200101010088",
    "200101072060",
    "230101020015",
    "200101010109",
    "220101020001",
    "200101010124",
    "220101020028",
    "200101010052",
    "200101010065",
    "200101010048",
    "220101020034",
    "200101072075",
    "230101020047",
    "200101010018",
    "200101010025",
    "200101010095",
    "200101010002",
    "200101010104",
    "230101020070",
    "200401072035",
    "220401020006",
    "200401010156",
    "220401020003",
    "200401010179",
    "200401010120",
    "200401072041",
    "200401072174",
    "200401072091",
    "200401010048",
    "220401020008",
    "230401020046",
    "220401020013",
    "200401072073",
    "200401010076",
    "200401010150",
    "200401010115",
    "220401020011",
    "230401020034",
    "200401072178",
    "200401072031",
    "230401020044",
    "230401020045",
    "200401010072",
    "230401020038",
    "200401010168",
    "200401072094",
    "200401010109",
    "220401020002",
    "220401020022",
    "200401010186",
    "11111",
    "22222",
    "33333",
    "44444",
    "55555"
];
        let validExtensions = ['image/jpeg', 'image/png', 'image/jpg'];
        let maxSize = 2 * 1024 * 1024; 

        if (email !== confirmEmail) {
            event.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Email dan Konfirmasi Email harus sama.',
            });
            return false;
        }

        if (!validNIMs.includes(nim)) {
            event.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'NIM Anda tidak terdaftar sebagai peserta wisuda.',
            });
            return false;
        }

        if (paymentFile) {
            if (!validExtensions.includes(paymentFile.type)) {
                event.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Hanya file dengan ekstensi jpg, jpeg, dan png yang diperbolehkan.',
                });
                return false;
            }

            if (paymentFile.size > maxSize) {
                event.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Ukuran file maksimal 2MB.',
                });
                return false;
            }
        }

        Swal.fire({
            icon: 'success',
            title: 'Pendaftaran Berhasil',
            text: 'Konfirmasi pendaftaran Anda telah berhasil. Selanjutnya, kami akan mengirimkan barcode sebagai tanda registrasi Anda beserta informasi penting lainnya terkait pelaksanaan wisuda pada Kamis, 05 Desember 2024. Terima kasih.',
        });
    });
</script>


</body>

</html>