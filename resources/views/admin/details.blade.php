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
                    <h3 class="text-xl font-semibold">{{ $registration->name }}</h3>
                    <p><strong>Nomor Handphone:</strong> {{ $registration->phone }}</p>
                    <p><strong>Email:</strong> {{ $registration->email }}</p>
                    <p><strong>Program Studi:</strong> {{ $registration->program_studi}}</p>
                    <p><strong>NIM:</strong> {{ $registration->nim }}</p>
                    <p><strong>Alamat:</strong> {{ $registration->address }}</p>
                    <p><strong>Kota/Kabupaten:</strong> {{ $registration->city }}</p>
                    <p><strong>Provinsi:</strong> {{ $registration->province }}</p>
                    <p><strong>ZIP:</strong> {{ $registration->postal_code }}</p>
                    <p><strong>Ukuran Toga:</strong> {{ $registration->toga_size }}</p>
                    <p><strong>Status:</strong> {{ ucfirst($registration->status) }}</p>
                    <p><strong>Tambahan:</strong> {{ $registration->number_of_guests }}</p>
                    <p><strong>Bukti Pembayaran:</strong> 
                        @if($registration->file_path)
                            <img src="{{ asset('storage/' . $registration->file_path) }}" alt="Foto" class="w-12 h-12 rounded-full" />
                        @else
                            <span>No photo</span>
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
