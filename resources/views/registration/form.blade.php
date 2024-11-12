<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pendaftaran Wisuda</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <form action="{{ route('registration.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow-md w-full max-w-md my-4">
        @csrf
        <h2 class="text-2xl font-bold text-center text-gray-700 mb-6">Form Pendaftaran Wisuda</h2>

        <div class="mb-4">
            <label class="block text-gray-600 font-semibold">Nama</label>
            <input type="text" name="name" required class="w-full mt-2 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>

        <div class="mb-4">
            <label class="block text-gray-600 font-semibold">No Handphone Aktif</label>
            <input type="text" name="phone" required class="w-full mt-2 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>

        <div class="mb-4">
            <label class="block text-gray-600 font-semibold">Email Aktif</label>
            <input type="email" name="email" required class="w-full mt-2 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>

        <div class="mb-4">
            <label class="block text-gray-600 font-semibold">Program Studi</label>
            <select name="program_studi" required class="w-full mt-2 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
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
            <input type="text" name="nim" required class="w-full mt-2 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>

        <div class="mb-4">
            <label class="block text-gray-600 font-semibold">Alamat Lengkap</label>
            <textarea name="address" required class="w-full mt-2 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" rows="3"></textarea>
        </div>

        <div class="mb-4">
            <label class="block text-gray-600 font-semibold">Kota/Kabupaten</label>
            <input type="text" name="city" required class="w-full mt-2 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>

        <div class="mb-4">
            <label class="block text-gray-600 font-semibold">Provinsi</label>
            <input type="text" name="province" required class="w-full mt-2 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>

        <div class="mb-4">
            <label class="block text-gray-600 font-semibold">Kode Pos</label>
            <input type="text" name="postal_code" required class="w-full mt-2 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>

        <div class="mb-4">
            <label class="block text-gray-600 font-semibold">Saya Mengikuti Wisuda Secara</label>
            <div class="flex items-center mt-2 space-x-4">
                <label class="flex items-center">
                    <input type="radio" name="graduation_type" value="online" required class="mr-2" id="online"> Online
                </label>
                <label class="flex items-center">
                    <input type="radio" name="graduation_type" value="onsite" required class="mr-2" id="onsite"> Onsite
                </label>
            </div>
        </div>

        <div class="mb-4" id="number_of_guests_container" style="display: none;">
            <label class="block text-gray-600 font-semibold">Jika mengikuti wisuda onsite, saya akan membawa berapa orang?</label>
            <input type="number" name="number_of_guests" min="0" class="w-full mt-2 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>

        <div class="mb-4 text-center">
            <img src="{{ url('/gambar/ukuran.jpeg') }}" alt="Gambar Toga" class="w-80 h-auto mx-auto mb-4 cursor-pointer" onclick="openModal()">
            <label class="block text-gray-600 font-semibold">Ukuran Toga</label>
            <select name="toga_size" required class="w-full mt-2 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                <option value="">-- Pilih Ukuran Toga --</option>
                <option value="S">S</option>
                <option value="M">M</option>
                <option value="L">L</option>
                <option value="XL">XL</option>
                <option value="XXL">XXL</option>
            </select>
        </div>

        <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center hidden">
            <img src="{{ url('/gambar/ukuran.jpeg') }}" alt="Gambar Toga Zoomed" class="max-w-full max-h-full">
            <button onclick="closeModal()" class="absolute top-4 right-4 text-white text-2xl font-bold">&times;</button>
        </div>

        <div class="mb-4">
            <label class="block text-gray-600 font-semibold">Bukti Pembayaran</label>
            <input type="file" name="file" required class="w-full mt-2 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>

        <button type="submit" class="w-full bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 transition duration-200">
            Submit
        </button>
        @if(session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: "{{ session('error') }}",
        });
    </script>
@endif

@if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Pendaftaran Berhasil',
            text: "{{ session('success') }}",
        });
    </script>
@endif
    </form>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.querySelector('form').addEventListener('submit', function(event) {
            let nim = document.querySelector('input[name="nim"]').value;
            let validNIMs = ['12345', '67890', '11223'];

            if (!validNIMs.includes(nim)) {
                event.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'NIM Anda tidak terdaftar sebagai peserta wisuda.',
                });
                return false;
            }

            const requiredFields = document.querySelectorAll('input[required], select[required], textarea[required]');
            let isFormValid = true;

            requiredFields.forEach(function(field) {
                if (!field.value) {
                    isFormValid = false;
                    field.classList.add('border-red-500');
                } else {
                    field.classList.remove('border-red-500');
                }
            });

            if (!isFormValid) {
                event.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Semua field wajib diisi.',
                });
                return false;
            }
        });

        document.getElementById('online').addEventListener('change', function() {
            document.getElementById('number_of_guests_container').style.display = 'none';
        });

        document.getElementById('onsite').addEventListener('change', function() {
            document.getElementById('number_of_guests_container').style.display = 'block';
        });
    </script>
</body>
</html>
