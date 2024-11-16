<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detail Mahasiswa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- Detail Section -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Left Column -->
                        <div>
                            <h3 class="text-xl font-semibold text-blue-600">{{ $registration->name }}</h3>
                            <p><strong>Nomor Handphone:</strong> {{ $registration->phone }}</p>
                            <p><strong>Email:</strong> {{ $registration->email }}</p>
                            <p><strong>Program Studi:</strong> {{ $registration->program_studi }}</p>
                            <p><strong>NIM:</strong> {{ $registration->nim }}</p>
                            <p><strong>Alamat:</strong> {{ $registration->address }}</p>
                            <p><strong>Kota/Kabupaten:</strong> {{ $registration->city }}</p>
                            <p><strong>Provinsi:</strong> {{ $registration->province }}</p>
                            <p><strong>ZIP:</strong> {{ $registration->postal_code }}</p>
                        </div>
                        
                        <!-- Right Column -->
                        <div>
                            <p><strong>Ukuran Toga:</strong> {{ $registration->toga_size }}</p>
                            <p><strong>Status:</strong> {{ ucfirst($registration->status) }}</p>
                            <p><strong>Tambahan:</strong> {{ $registration->number_of_guests }}</p>
                            <div class="mt-4">
                                <strong>Bukti Pembayaran:</strong>
                                @if($registration->graduation_payment_file)
                                    <div class="relative">
                                        <img id="payment-proof" src="{{ asset('storage/' . $registration->graduation_payment_file) }}" alt="Bukti Pembayaran" class="w-full h-auto cursor-zoom-in rounded-lg shadow-lg" />
                                        <div class="absolute inset-0 bg-black opacity-50 flex justify-center items-center text-white text-xl font-bold rounded-lg" style="display: none" id="zoom-text">Zoom</div>
                                    </div>
                                @else
                                    <span>No photo available</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Add a button to download file if needed -->
                    @if($registration->graduation_payment_file)
                        <div class="mt-4">
                            <a href="{{ asset('storage/' . $registration->graduation_payment_file) }}" class="text-blue-600 hover:underline" download>
                                Download Bukti Pembayaran
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Script untuk zoom gambar -->
    <script>
        var zooming = new Zooming({
            customSize: 600 // Menentukan ukuran zoom
        });
        zooming.listen('#payment-proof');
        
        // Menampilkan overlay ketika gambar di-zoom
        document.getElementById('payment-proof').addEventListener('mouseover', function() {
            document.getElementById('zoom-text').style.display = 'flex';
        });
        document.getElementById('payment-proof').addEventListener('mouseleave', function() {
            document.getElementById('zoom-text').style.display = 'none';
        });
    </script>
</x-app-layout>
